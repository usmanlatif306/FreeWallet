<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Deposit;
use Mail;
use App\Mail\Deposit\depositRequestUserEmail;
use App\Mail\Depoist\depositRequestAdminNotificationEmail;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\DepositMethod;
use App\Models\TransferMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AddCreditController extends Controller
{
    public function AddCreditForm($lang, $method_id = false)
    {
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        $methods = Auth::user()->currentCurrency()->DepositMethods()->get();
        if ($method_id) {

            $current_method = DepositMethod::where('id', $method_id)->with('currencies')->first();

            if ($current_method == null) {
                dd('please contact admin to link a deposit method to ' . Auth::user()->currentCurrency()->name . ' currency');
            }
        } else {
            if (isset($methods[0])) {
                $current_method = $methods[0];
            } else {
                dd('please contact admin to link a deposit method to ' . Auth::user()->currentCurrency()->name . ' currency');
            }
        }


        $currencies = Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get();

        return view('deposits.addCreditForm')
            ->with('current_method', $current_method)
            ->with('currencies', $currencies)
            ->with('methods', $methods);
    }

    public function depositMethods()
    {
        $methods = DepositMethod::all();

        return view('deposits.methods')->with('methods', $methods);
    }

    public function depositByWallet(Request $request, $lang, $id)
    {

        return view('deposits.transfer')
            ->with('transferMethod', Auth::user()->currentWallet()->transferMethod)->with('wid', $id);
    }

    public function depositRequest(Request $request, $laang)
    {

        $this->validate($request, [
            'deposit_screenshot'    => 'required|mimes:jpg,png,jpeg',
            'message'   =>  'required',
            'unique_transaction_id'  =>  'required',
            'tmid'  =>  'required|exists:transfer_methods,id',
            'wid' =>  'required|exists:wallets,id',
        ]);

        $transferMethod = TransferMethod::findOrFail($request->tmid);
        $wallet = Wallet::findOrFail($request->wid);

        if ($wallet->user_id != Auth::user()->id) {

            abort(404);
        }

        if ($request->hasFile('deposit_screenshot')) {
            $file = $request->file('deposit_screenshot');
            $path = 'users/' . Auth::user()->name . '/deposits/' . preg_replace('/\s/', '', $file->getClientOriginalName());
            Storage::put($path, $file);

            $local_path = Storage::put($path, $file);

            $link = Storage::url($local_path);
        }



        $depositRequest = Deposit::create([
            'user_id'    =>    Auth::user()->id,
            'wallet_id' =>  $wallet->id,
            'currency_id'   =>  $transferMethod->currency_id,
            'currency_symbol'   =>  $transferMethod->currency->symbol,
            'transaction_state_id'    =>    3,
            'deposit_method_id'    =>    1,
            'gross'    =>    0,
            'fee'    =>    0,
            'net'    =>    0,
            'message'   =>  $request->message,
            'transaction_receipt'    =>    $link,
            'json_data'    =>    '{"deposit_screenshot":"' . $path . '"}',
            'transfer_method_id' => $transferMethod->id,
            'unique_transaction_id' => $request->unique_transaction_id,
        ]);

        //send notification to admin

        //Mail::send(new depositRequestAdminNotificationEmail( $depositRequest, Auth::user()));

        //Send new deposit request notification Mail to user
        Mail::send(new depositRequestUserEmail($depositRequest, Auth::user()));

        flash('Your Deposit is Waiting for a review', 'info');

        return  redirect(route('mydeposits', app()->getLocale()));
    }
}
