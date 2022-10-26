<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Mail;
use App\Models\Deposit;
use App\Models\TransferMethod;
use App\Mail\Deposit\depositCompletedUserNotificationEmail;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function myDeposits(Request $request, $lang)
    {
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        $deposits = Deposit::with(['transferMethod', 'Status'])->where('user_id', Auth::user()->id)->orderby('created_at', 'desc')->paginate(10);
        return view('deposits.index')
            ->with('deposits', $deposits);
    }

    public function confirmDeposit(Request $request, $lang)
    {
        if (Auth::user()->isAdministrator() == false) {
            abort(404);
        }
        $request->gross = 0;

        $deposit = Deposit::with('transferMethod')->findOrFail($request->id);

        $transferMethod = TransferMethod::findOrFail($deposit->transfer_method_id);


        if ($deposit->transaction_state_id == 1) {
            return redirect(url('/') . '/admin/dashboard/deposits/' . $deposit->id);
        }

        $user = User::findOrFail($request->user_id);

        $wallet = Wallet::findOrFail($deposit->wallet_id);

        $deposit_fee = 0;


        if ($wallet->is_crypto == 1) {
            $precision = 8;
        } else {
            $precision = 2;
        }
        $deposit_fee = bcadd(bcmul(($transferMethod->deposit_percentage_fee / 100), $request->gross, $precision), $transferMethod->deposit_fixed_fee, $precision);

        $deposit_net = bcsub($request->gross, $deposit_fee, $precision);

        $wallet->amount = bcadd('' . $user->balance, '' . $deposit_net, $precision);


        $user->RecentActivity()->save($deposit->Transactions()->create([
            'user_id' => $user->id,
            'entity_id'   =>  $user->id,
            'entity_name' =>   $transferMethod->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'activity_title'    =>  'Deposit',
            'balance'    =>     $wallet->balance,
            'currency_id'   =>  $deposit->currency_id,
            'currency_symbol'   =>  $deposit->currency_symbol,
            'thumb' =>  $transferMethod->thumbnail,
            'gross' =>  $request->gross,
            'fee'   =>  $deposit_fee,
            'net'   =>  $deposit_net
        ]));



        $deposit->gross = $request->gross;
        $deposit->fee = $deposit_fee;
        $deposit->net = $deposit_net;
        $deposit->transaction_state_id = 1;

        $deposit->save();
        $wallet->save();


        Mail::send(new depositCompletedUserNotificationEmail($deposit, $user));

        return redirect(url('/') . '/admin/dashboard/deposits/' . $deposit->id);
    }
}
