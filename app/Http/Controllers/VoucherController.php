<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Currency;
use App\Models\Wallet;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    public function buyvouchermethod(Request $request, $lang)
    {
        return view('vouchers.purchase_method');
    }

    public function getVouchers(Request $request, $lang)
    {
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        $vouchers = Voucher::with('User', 'Loader')->where('user_id', Auth::user()->id)->orwhere('user_loader', Auth::user()->id)->orderby('created_at', 'desc')->paginate(5);
        $currencies = Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get();
        return view('vouchers.index')
            ->with('currencies', $currencies)
            ->with('vouchers', $vouchers);
    }

    public function loadVoucher(Request $request, $lang)
    {
        // if user has not 2fa verifies
        if (!Auth::user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        $this->validate($request, [
            'voucher_code'    =>    'exists:vouchers,voucher_code',
        ]);

        $voucher = Voucher::where('voucher_code', $request->voucher_code)->where('is_loaded', 0)->first();
        if ($voucher == null) {
            return back();
        }
        $wallet = Wallet::where('currency_id', $voucher->currency_id)->where('user_id', Auth::user()->id)->first();


        $currency = Currency::where('id', $voucher->currency_id)->first();

        if ($currency->is_crypto == 1) {
            $precision = 8;
        } else {
            $precision = 2;
        }

        if (is_null($wallet)) {
            $wallet = Wallet::create([
                'user_id'   =>  Auth::user()->id,
                'currency_id'   =>  $voucher->currency_id,
                'is_crypto' =>  $currency->is_crypto
            ]);
        }


        $wallet->amount = bcadd($wallet->amount, $voucher->voucher_value, $precision);

        $voucher->user_loader = Auth::user()->id;

        $voucher->is_loaded = 1;

        $voucher->save();

        $wallet->save();


        Auth::user()->RecentActivity()->save($voucher->Transactions()->create([
            'user_id' =>  Auth::user()->id,
            'entity_id'   =>  $voucher->id,
            'entity_name' =>  $wallet->currency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'activity_title'    =>  'Voucher Load',
            'currency_id' =>  $voucher->currency_id,
            'currency_symbol' =>  $voucher->currency_symbol,
            'thumb' =>  $wallet->currency->thumb,
            'gross' =>  $voucher->voucher_value,
            'fee'   =>  0,
            'net'   =>  $voucher->voucher_value,
            'balance'    =>    $wallet->amount,
        ]));

        flash('Voucher loaded successfully', 'info');
        return redirect(app()->getLocale() . '/home');
    }

    public function createVoucher(Request $request, $lang)
    {
        // if user has not 2fa verifies
        if (!Auth::user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        $this->validate($request, [
            'voucher_currency'    =>    'exists:currencies,id|numeric',
            'balance_amount'    =>    'required|numeric'
        ]);

        $wallet = Auth::user()->currentWallet();
        $currency = $wallet->currency;

        if ($currency->is_crypto == 1) {
            $precision = 8;
        } else {
            $precision = 2;
        }


        $fee = bcadd(bcmul('' . (setting('money-transfers.mt_percentage_fee') / 100), $request->balance_amount, $precision), setting('money-transfers.mt_fixed_fee'), $precision);

        if ($currency->is_crypto == 1) {
            $fee =  bcmul('' . (setting('money-transfers.mt_percentage_fee') / 100), $request->balance_amount, $precision);
        }


        if ($wallet->amount < $fee) {
            flash(__('You have insufficient funds to create voucher') . ' <strong>' . $request->balance_amount . __('to') . 'generate a voucher' . '</strong>', 'danger');
            return  back();
        }

        if ($wallet->amount < (float)$request->balance_amount) {
            flash(__('You have insufficient funds to create voucher') . ' <strong>' . $request->balance_amount . __('to') . 'generate a voucher' . '</strong>', 'danger');
            return  back();
        }


        $voucher_value = bcsub($request->balance_amount, $fee, $precision);


        $voucher = Voucher::create([
            'user_id'    =>    Auth::user()->id,
            'voucher_amount'    =>    $request->balance_amount,
            'voucher_fee'    =>    $fee,
            'voucher_value'    =>    $voucher_value,
            'voucher_code'    =>    Auth::user()->id . str_random(4) . time() . str_random(4),
            'currency_id'    =>    $wallet->currency->id,
            'currency_symbol'    =>    $wallet->currency->symbol,
            'wallet_id'    =>    $wallet->id
        ]);
        dd($voucher);
        $wallet->amount = bcsub($wallet->amount, $request->balance_amount, $precision);

        $wallet->save();

        Auth::user()->RecentActivity()->save($voucher->Transactions()->create([
            'user_id' =>  Auth::user()->id,
            'entity_id'   =>  $voucher->id,
            'entity_name' =>  $wallet->currency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '-',
            'activity_title'    =>  'Voucher Generation',
            'currency_id' =>  $voucher->currency_id,
            'currency_symbol' =>  $voucher->currency_symbol,
            'thumb' =>  $wallet->currency->thumb,
            'gross' =>  $voucher->voucher_amount,
            'fee'   =>  $voucher->voucher_fee,
            'net'   =>  $voucher->voucher_value,
            'balance'    =>    $wallet->amount,
        ]));

        flash('Voucher generated successfully', 'info');

        return back();
        //validate the wallet balance 
    }

    public function generateVoucher(Request $request, $lang)
    {
        if (Auth::user()->role_id != 1 and Auth::user()->role_id != 3) {
            return back();
        }
        $vouchers = Voucher::with('User', 'Loader')->where('user_id', Auth::user()->id)->orwhere('user_loader', Auth::user()->id)->orderby('created_at', 'desc')->paginate(5);
        $currencies = Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get();
        return view('vouchers.generate')
            ->with('currencies', $currencies)
            ->with('vouchers', $vouchers);
    }

    public function postGenerateVoucher(Request $request, $lang)
    {

        if (Auth::user()->role_id != 1) {
            return back();
        }


        $this->validate($request, [
            'voucher_currency'  =>  'exists:currencies,id|numeric',
            'balance_amount'    =>  'required|numeric'
        ]);

        $fee = 0;

        $wallet = Auth::user()->currentWallet();
        $currency = $wallet->Currency;

        if ($currency->is_crypto == 1) {
            $precision = 8;
        } else {
            $precision = 2;
        }


        $voucher_value = bcsub($request->balance_amount, $fee, $precision);




        $voucher = Voucher::create([
            'user_id'   =>  Auth::user()->id,
            'voucher_amount'    =>  $request->balance_amount,
            'voucher_fee'   =>  $fee,
            'voucher_value' =>  $voucher_value,
            'voucher_code'  =>  Auth::user()->id . str_random(4) . time() . str_random(4),
            'currency_id'   =>  $wallet->currency->id,
            'currency_symbol'   =>  $wallet->currency->symbol,
            'wallet_id' =>  $wallet->id
        ]);


        Auth::user()->RecentActivity()->save($voucher->Transactions()->create([
            'user_id' =>  Auth::user()->id,
            'entity_id'   =>  $voucher->id,
            'entity_name' =>  $wallet->currency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '↑',
            'activity_title'    =>  'Added Voucher to system',
            'currency_id' =>  $voucher->currency_id,
            'currency_symbol' =>  $voucher->currency_symbol,
            'thumb' =>  $wallet->currency->thumb,
            'gross' =>  $voucher->voucher_amount,
            'fee'   =>  $voucher->voucher_fee,
            'net'   =>  $voucher->voucher_value,
            'balance'   =>  $wallet->amount,
        ]));

        flash('Voucher generated successfully', 'info');

        return back();
    }

    public function loadVoucherToUser(Request $request, $lang)
    {

        if (Auth::user()->role_id != 1 and Auth::user()->role_id != 3) {
            return back();
        }

        $this->validate($request, [
            'voucher_code'  =>  'exists:vouchers,voucher_code',
            'user_name'  =>  'exists:users,name',
        ]);

        $user = \App\User::where('name', $request->user_name)->first();

        $voucher = Voucher::where('voucher_code', $request->voucher_code)->where('is_loaded', 0)->first();
        if ($voucher == null) {
            return back();
        }

        $currency = Currency::where('id', $voucher->currency_id)->first();

        if ($currency->is_crypto == 1) {
            $precision = 8;
        } else {
            $precision = 2;
        }

        $wallet = Wallet::where('currency_id', $voucher->currency_id)->where('user_id', $user->id)->first();

        if (is_null($wallet)) {
            flash('user doesnt have an active wallet in ' . $currency->name, 'info');
            return back();
        }


        $wallet->amount = bcadd($wallet->amount, $voucher->voucher_value, $precision);

        $voucher->user_loader = $user->id;

        $voucher->is_loaded = 1;

        $voucher->save();

        $wallet->save();


        $user->RecentActivity()->save($voucher->Transactions()->create([
            'user_id' =>  $user->id,
            'entity_id'   =>  $voucher->id,
            'entity_name' =>  $wallet->currency->name,
            'transaction_state_id'  =>  1, //completed
            'money_flow'    => '+',
            'activity_title'    =>  'Voucher Load',
            'currency_id' =>  $voucher->currency_id,
            'currency_symbol' =>  $voucher->currency_symbol,
            'thumb' =>  $wallet->currency->thumb,
            'gross' =>  $voucher->voucher_value,
            'fee'   =>  0,
            'net'   =>  $voucher->voucher_value,
            'balance'   =>  $wallet->amount,
        ]));

        if (Auth::user()->role_id == 1) {
            Auth::user()->impersonate($user);
        }
        flash('voucher loaded successfully ask ' . $user->name . ' to check his balance', 'info');
        return redirect(app()->getLocale() . '/home');
    }

    public function buyvoucher(Request $request, $lang)
    {
        $user = Auth::user();
        $user->currency_id = 1;
        $user->save();
        return view('vouchers.buy');
    }
}
