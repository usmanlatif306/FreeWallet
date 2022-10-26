<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\User;
use App\Models\Send;
use App\Models\Currency;
use App\Models\Receive;
use App\Models\Transaction;
use App\Notifications\MoneyReceivedNotification;
use App\Notifications\MoneySendNotification;
use Validator;
use Illuminate\Http\Request;
use App\Services\Verify2FA;

class MoneyTransferController extends Controller
{
    public function sendMoneyForm(Request $request, $lang)
    {
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        $currencies = Currency::where('id', '!=', Auth::user()->currentWallet()->currency_id)->get();
        return view('sendmoney.index')->with('currencies', $currencies);
    }

    public function requestMoneyForm(Request $request, $lang)
    {
        // if user has not 2fa verifies
        if (!Auth::user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        $currencies = Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get();
        return view('requestmoney.index')->with('currencies', $currencies);
    }

    public function sendMoney(Request $request, $lang)
    {
        $this->validate($request, [
            'secret' => 'required|numeric',
        ]);
        // validating google authenticator code
        // $valid = (new Verify2FA())->validate($request->input('secret'));
        $valid = true;
        // 
        if (!$valid) {
            flash(__('Invalid verification Code, Please try again.'), 'danger');
            return back();
        } else {
            if ($request->amount <= 0) {
                flash(__('Please insert an amount greater than 0'), 'danger');
                return back();
            }
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

                $this->validate($request, [
                    'amount'    =>  'required|numeric|between:0,' . Auth::user()->currentWallet()->amount,
                    'description'   =>  'required|string',
                    'email' =>  'required|email|exists:users,email',
                ]);
            } else {

                $this->validate($request, [
                    'amount'    =>  'required|numeric|between:0,' . Auth::user()->currentWallet()->amount,
                    'description'   =>  'required|string',

                ]);
            }
            $valid_user = User::where('email', $request->email)->first();
            // if user is registered on our website
            if (!is_null($valid_user)) {

                // $currency = Currency::find(Auth::user()->currency_id);
                $currency = Currency::find(Auth::user()->currentWallet()->currency_id);

                if ($currency->is_crypto == 1) {
                    $precision = 8;
                } else {
                    $precision = 2;
                }

                // $auth_wallet = Auth::user()->walletByCurrencyId($currency->id);
                $auth_wallet = Auth::user()->currentWallet();

                if ((bool)$currency == false) {
                    flash(__('Wops, something went wrong... looks like we do not support this currency. please contact support if this error persists !'), 'danger');
                    return back();
                }

                if (Auth::user()->account_status == 0) {
                    flash(__('Your account is under a withdrawal request review proccess. please wait for a few minutes and try again'), 'info');
                    return  back();
                }


                if ($request->email == Auth::user()->email) {
                    flash(__('You can\'t send money to the same account you are in'), 'danger');
                    return  back();
                }

                if ($request->amount > $auth_wallet->amount) {
                    flash(__('You have insufficient funds to send') . ' <strong>' . $request->amount . __('to') . $request->email . '</strong>', 'danger');
                    return  back();
                }

                if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $user = User::where('email', $request->email)->first();
                } else {
                    $user = $valid_user;
                }

                if ($user->id == Auth::user()->id) {
                    flash(__('Not alowed to send or receive funds from your own account'), 'danger');
                    return  back();
                }

                // $user_wallet = $user->walletByCurrencyId($currency->id);
                $user_wallet = $user->currentWallet();

                if ($user_wallet == NULL) {
                    flash(__('The user ' . $user->name . " have not activated a wallet on his account yet !"), 'danger');
                    return  back();
                }

                $send_fee = 0; //free to send money

                if ($currency->is_crypto == 1) {

                    $receive_fee = bcmul('' . (setting('money-transfers.mt_percentage_fee') / 100), $request->amount, $precision);
                } else if ($currency->is_crypto == 0) {

                    $receive_fee = bcadd(bcmul('' . (setting('money-transfers.mt_percentage_fee') / 100), $request->amount, $precision), setting('money-transfers.mt_fixed_fee'), $precision);
                }

                if (($request->amount - (float) $receive_fee) < 0) {
                    flash(__('The minimum amount to send is') . ' <strong>' . bcsub($request->amount, $receive_fee, $precision) . '</strong>', 'danger');
                    return  back();
                }

                $receive = Receive::create([
                    'user_id'   =>   $user->id,
                    'from_id'        => Auth::user()->id,
                    'transaction_state_id'  =>  3, // waiting confirmation
                    'gross'    =>  $request->amount,
                    'currency_id' =>  $currency->id,
                    'currency_symbol' =>  $currency->symbol,
                    'fee'   =>  $receive_fee,
                    'net'   =>  bcsub($request->amount, $receive_fee, $precision),
                    'description'   =>  $request->description,
                ]);

                $send = Send::create([
                    'user_id'   =>  Auth::user()->id,
                    'to_id'        =>  $user->id,
                    'transaction_state_id'  =>  3, // waiting confirmation 
                    'gross'    =>  $request->amount,
                    'currency_id' =>  $currency->id,
                    'currency_symbol' =>  $currency->symbol,
                    'fee'   =>  $send_fee,
                    'net'   =>  bcsub($request->amount, $send_fee, $precision),
                    'description'   =>  $request->description,
                    'receive_id'    =>  $receive->id
                ]);

                $receive->send_id = $send->id;
                $receive->save();

                $user->RecentActivity()->save($receive->Transactions()->create([
                    'user_id' => $receive->user_id,
                    'entity_id'   =>  $receive->id,
                    'entity_name' =>  Auth::user()->name,
                    'transaction_state_id'  =>  3, // waiting confirmation
                    'money_flow'    => '+',
                    'currency_id' =>  $currency->id,
                    'thumb' =>  Auth::user()->avatar,
                    'currency_symbol' =>  $currency->symbol,
                    'activity_title'    =>  $currency->is_crypto ? 'Coin Received' : 'Money Received',
                    'gross' =>  $receive->gross,
                    'fee'   =>  $receive->fee,
                    'net'   =>  $receive->net,
                ]));

                Auth::user()->RecentActivity()->save($send->Transactions()->create([
                    'user_id' =>  Auth::user()->id,
                    'entity_id'   =>  $send->id,
                    'entity_name' =>  $user->name,
                    'transaction_state_id'  =>  3, // waiting confirmation
                    'money_flow'    => '-',
                    'thumb' =>  $user->avatar,
                    'currency_id' =>  $currency->id,
                    'currency_symbol' =>  $currency->symbol,
                    'activity_title'    => $currency->is_crypto ? 'Coin Sent' : 'Money Sent',
                    'gross' =>  $send->gross,
                    'fee'   =>  $send->fee,
                    'net'   =>  $send->net
                ]));
            } else {
                // if user is not registered on our website and api will call
                flash(__('The Username ') . $request->email . __(' is invalid'), 'danger');
                return back();
            }
        }


        return  redirect(route('home', app()->getLocale()));
    }

    public function requestMoney(Request $request, $lang)
    {


        if ($request->amount <= 0) {
            flash(__('Please insert an amount greater than 0'), 'danger');
            return back();
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

            $this->validate($request, [
                'amount'    =>  'required|numeric|min:2',
                'description'   =>  'required|string',
                'email' =>  'required|email|exists:users,email',
            ]);
        } else {

            $this->validate($request, [
                'amount'    =>  'required|numeric|between:0,' . Auth::user()->currentWallet()->amount,
                'description'   =>  'required|string',

            ]);

            $valid_user = User::where('name', $request->email)->first();



            if (is_null($valid_user)) {

                flash(__('The Username ') . $request->email . __(' is invalid'), 'danger');
                return back();
            }
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = $valid_user;
        }


        if ($user->id == Auth::user()->id) {
            flash(__('Not alowed to send or receive funds from your own account'), 'danger');
            return  back();
        }


        $currency = Currency::find(Auth::user()->currency_id);

        if ($currency->is_crypto == 1) {
            $precision = 8;
        } else {
            $precision = 2;
        }

        $auth_wallet = $user->walletByCurrencyId($currency->id);
        if ($auth_wallet == NULL) {
            flash(__('The user ' . $user->name . " have not activated a wallet on his account yet !"), 'danger');
            return  back();
        }

        if ((bool)$currency == false) {
            flash(__('Wops, something went wrong... looks like we do not support this currency. please contact support if this error persists !'), 'danger');
            return back();
        }

        if (Auth::user()->account_status == 0) {
            flash($user->name . __(' account is under a withdrawal request review proccess. please wait for a few minutes and try again'), 'info');
            return  back();
        }


        if ($request->email == Auth::user()->email) {
            flash(__('You can\'t request money to the same account you are in'), 'danger');
            return  back();
        }

        if ($request->amount > $auth_wallet->amount) {
            flash($user->name . __(' has insufficient funds to send') . ' <strong>' . $request->amount . __('to') . __('you') . '</strong>', 'danger');
            return  back();
        }

        // if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        //     $user = User::where('email', $request->email)->first();
        // }else{
        //     $user = $valid_user ;
        // }

        $send_fee = 0; //free to send money

        if ($currency->is_crypto == 1) {

            $receive_fee = bcmul('' . (setting('money-transfers.mt_percentage_fee') / 100), $request->amount, $precision);
        } else if ($currency->is_crypto == 0) {

            $receive_fee = bcadd(bcmul('' . (setting('money-transfers.mt_percentage_fee') / 100), $request->amount, $precision), setting('money-transfers.mt_fixed_fee'), $precision);
        }

        if (($request->amount - $receive_fee) < 0) {
            flash(__('The minimum amount to send is') . ' <strong>' . bcsub($request->amount, $receive_fee, $precision) . '</strong>', 'danger');
            return  back();
        }

        $receive = Receive::create([
            'user_id'   =>   Auth::user()->id,
            'from_id'        => $user->id,
            'transaction_state_id'  =>  3, // waiting confirmation
            'gross'    =>  $request->amount,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $receive_fee,
            'net'   => bcsub($request->amount, $receive_fee, $precision),
            'description'   =>  $request->description,
        ]);

        $send = Send::create([
            'user_id'   =>  $user->id,
            'to_id'        =>  Auth::user()->id,
            'transaction_state_id'  =>  3, // waiting confirmation 
            'gross'    =>  $request->amount,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $send_fee,
            'net'   =>  bcsub($request->amount, $send_fee, $precision),
            'description'   =>  $request->description,
            'receive_id'    =>  $receive->id
        ]);

        $receive->send_id = $send->id;
        $receive->save();

        Auth::user()->RecentActivity()->save($receive->Transactions()->create([
            'user_id' => $receive->user_id,
            'entity_id'   =>  $receive->id,
            'entity_name' =>  Auth::user()->name,
            'transaction_state_id'  =>  3, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' =>  $currency->id,
            'thumb' =>  Auth::user()->avatar,
            'currency_symbol' =>  $currency->symbol,
            'activity_title'    =>  $currency->is_crypto ? 'Coin Received' : 'Money Received',
            'gross' =>  $receive->gross,
            'fee'   =>  $receive->fee,
            'net'   =>  $receive->net,
        ]));

        $user->RecentActivity()->save($send->Transactions()->create([
            'user_id' =>  Auth::user()->id,
            'entity_id'   =>  $send->id,
            'entity_name' =>  $user->name,
            'transaction_state_id'  =>  3, // waiting confirmation
            'money_flow'    => '-',
            'thumb' =>  $user->avatar,
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'activity_title'    =>  $currency->is_crypto ? 'Coin Sent' : 'Money Sent',
            'gross' =>  $send->gross,
            'fee'   =>  $send->fee,
            'net'   =>  $send->net
        ]));

        return  redirect(route('home', app()->getLocale()));
    }


    public function sendMoneyConfirm(Request $request, $lang)
    {
        $this->validate($request, [
            'tid'   => 'required|numeric',
        ]);

        $transaction = Transaction::find($request->tid);

        $currency = Currency::find($transaction->currency_id);

        if ($currency->is_crypto == 1) {
            $precision = 8;
        } else {
            $precision = 2;
        }

        // $auth_wallet = Auth::user()->walletByCurrencyId($currency->id);
        $auth_wallet = Auth::user()->currentWallet($currency->id);

        if ((bool)$transaction == false) {
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        if (Auth::user()->account_status == 0) {
            flash(__('Your account is under a withdrawal request review proccess. please wait for a few minutes and try again'), 'info');
            return  back();
        }

        if (Auth::user()->id != $transaction->user_id) {
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        $send = Send::find($transaction->transactionable_id);

        if ((bool)$send == false) {
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        if (Auth::user()->id != $send->user_id) {
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        $receive = Receive::find($send->receive_id);

        if ((bool)$receive == false) {
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        $user = User::find($receive->user_id);

        // $user_wallet = $user->walletByCurrencyId($currency->id);
        $user_wallet = $user->currentWallet();


        if ((bool)$user == false) {
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        $receive_transaction = transaction::where('transactionable_type', 'App\Models\Receive')->where('user_id', $user->id)->where('transaction_state_id', 3)->where('money_flow', '+')->where('transactionable_id', $receive->id)->first();

        if ((bool)$receive_transaction == false) {
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        if ((float)$auth_wallet->amount < (float)$transaction->net) {
            flash(__('You have insufficient funds to send') . ' <strong>' . $request->amount . __('to') . $request->email . '</strong>', 'danger');
            return  back();
        }
        // $user is receiver acoount
        // sending money send notification to sender
        // $notify_amount = str_replace("- ", "", $transaction->net());
        // Auth::user()->notify(new MoneySendNotification($user->name, $notify_amount));
        // // sending money receive notification to receiver
        // $user->notify(new MoneyReceivedNotification(auth()->user()->name, $notify_amount));

        $receive->send_id = $send->id;
        $receive->transaction_state_id = 1;
        $receive->save();

        $send->transaction_state_id = 1;
        $send->save();

        $transaction->transaction_state_id = 1;
        $transaction->balance = bcsub($auth_wallet->amount, $transaction->net, $precision);
        $transaction->save();

        $receive_transaction->transaction_state_id = 1;
        $receive_transaction->balance =  bcadd($user_wallet->amount, $receive_transaction->net, $precision);
        $receive_transaction->save();

        $auth_wallet->amount = bcsub($auth_wallet->amount, $transaction->net, $precision);
        $auth_wallet->save();

        $user_wallet->amount =  bcadd($user_wallet->amount,  $receive_transaction->net, $precision);
        $user_wallet->save();


        flash(__('Transaction Complete'), 'success');

        return  back();
    }
    public function sendMoneyCancel(Request $request, $lang)
    {
        $this->validate($request, [
            'tid'   => 'required|numeric',
        ]);

        $transaction = Transaction::findOrFail($request->tid);
        $send = Send::findOrFail($transaction->transactionable_id);

        $receive = Receive::findOrFail($send->receive_id);

        $receive->delete();
        $send->delete();
        $transaction->delete();

        flash(__('Transaction Canceled'), 'success');

        return  back();
    }
}
