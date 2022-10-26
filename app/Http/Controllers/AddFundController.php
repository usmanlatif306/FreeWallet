<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\CurrencyExchangeRate;
use App\Models\Deposit;
use App\Models\TransferMethod;
use App\Models\Wallet;
use App\Notifications\MoneyReceivedNotification;
use App\Services\CurrencyExchange;
use App\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\InvalidRequestException;

class AddFundController extends Controller
{
    public function index()
    {
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }

        $currencies = Country::countries();

        return view('addfund.index', compact('currencies'));
    }

    // payment is successfull and create stripe payment and add funds to user wallet
    public function captureFund(Request $request, CurrencyExchange $service)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $token = request('stripeToken');
            $charge = Charge::create([
                'amount' => request('amount') * 100,
                'currency' => strtolower(request('currency')),
                'description' => 'Payment to recharge wallet',
                'source' => $token,
            ]);
        } catch (InvalidRequestException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        // payment is done and now transfer deposit amount in user wallet
        $user = User::findOrFail(auth()->user()->id);

        $wallet = Wallet::where('user_id', $user->id)->first();

        $transferMethod = TransferMethod::findOrFail($wallet->transfer_method_id);

        $currency = Currency::findOrFail($wallet->currency_id);

        if ($wallet->is_crypto) {
            $exchange_rate = $service->getPrice(request('currency'));
        } else {
            // $exchange_rate = CurrencyExchangeRate::where(['first_currency_id' => 1, 'second_currency_id' => $currency->id])->first()->exchanges_to_second_currency_value;
            $exchange_rate = 1;
        }


        // $convertAmount = $request->amount / $price;

        $deposit_fee = 0;
        $request->gross = $request->amount / $exchange_rate;

        if ($wallet->is_crypto == 1) {
            $precision = 8;
        } else {
            $precision = 2;
        }

        $deposit_fee = bcadd(bcmul(($transferMethod->deposit_percentage_fee / 100), $request->gross, $precision), $transferMethod->deposit_fixed_fee, $precision);

        $deposit_net = bcsub($request->gross, $deposit_fee, $precision);

        $wallet->amount = bcadd('' . $user->balance, '' . $deposit_net, $precision);

        $deposit = Deposit::create([
            'user_id' => $user->id,
            'transaction_state_id' => 1,
            'deposit_method_id' => 2,
            'gross' => $request->gross,
            'fee' => $deposit_fee,
            'net' => $deposit_net,
            'wallet_id' => $wallet->id,
            'currency_id' => $currency->id,
            'currency_symbol' => $currency->symbol,
            'transfer_method_id' => $transferMethod->id,
            'transaction_receipt' => 'storage/transfer-methods/stripe-odd.png'
        ]);

        $deposit_transaction = $deposit->Transactions()->create([
            'user_id' => $user->id,
            'entity_id'   =>  $user->id,
            'entity_name' =>   'Stripe', //$transferMethod->name
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'activity_title'    =>  'Deposit',
            'balance'    =>     $wallet->is_crypto == 1 ? $wallet->crypto : $wallet->fiat,
            'currency_id'   =>  $deposit->currency_id,
            'currency_symbol'   =>  $deposit->currency_symbol,
            'thumb' =>  'storage/imgs/xNyqTMuGhvfDAQGIpWxfWrz9K49MEpYlvWJgLPeG.jpeg', //$transferMethod->thumbnail
            'gross' =>  $request->gross,
            'fee'   =>  $deposit_fee,
            'net'   =>  $deposit_net

        ]);
        $user->RecentActivity()->save($deposit_transaction);

        $deposit->unique_transaction_id = $deposit_transaction->id;

        $deposit->save();
        $wallet->save();

        // sending money receive notification to user
        $notify_amount = $deposit_net . ' ' . $deposit->currency_symbol;
        $user->notify(new MoneyReceivedNotification('Credit Card Method', $notify_amount));

        return redirect(route('home', app()->getLocale()));
    }
}
