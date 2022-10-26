<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Escrow;
use App\User;
use Twilio;
use App\Models\Otp;
use App\Models\Wallet;
use App\Models\Receive;
use App\Models\Transactions;
use App\Models\Currrency;
use App\Services\BlockApiService;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use Jenssegers\Agent\Agent;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getPage']]);
    }

    public function getPage(Request $request, $lang, $id)
    {

        $page = Page::where('id', $id)->first();

        if ($page != null) {
            return view('page.show')->with('page', $page);
        }

        return abort(404);
    }

    public function accountStatus(Request $request, $lang, $user)
    {
        $user = User::findOrFail($user);
        $user->account_status = 0;
        $user->save();
        return back();
    }
    public function locale(Request $request, $lang, $locale)
    {

        dd($locale);
        App::setLocale($locale);
        return view('welcome');
    }

    public function wallet(Request $request, $lang,  $id)
    {
        $wallet = Wallet::findOrFail($id);

        if ($wallet) {

            Auth::user()->wallet_id = $wallet->id;
            Auth::user()->save();
        }
        return back();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlockApiService $service)
    {

        $agent = new Agent();

        // Twilio::message('+258850586897', array(
        //     'body' => 'hihaa',
        //     'SERVICE SID'  =>  'Envato',
        // ));
        if (!Auth::user()->verified) {
            return view('otp.index');
        }
        // dd('ff', auth()->user()->enabled_2fs());
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }

        $has_wallet = $username = Auth::user()->currentWallet()->accont_identifier_mechanism_value ?? null;
        if (is_null($has_wallet)) {
            //return redirect(app()->getLocale().'/transfer/methods');
            return redirect(route('show.currencies', app()->getLocale()));
        }

        // if wallet is crypto then fetch wallet balance
        if (auth()->user()->currentWallet()->is_crypto) {
            // if user has not wallet address
            if (Auth::user()->address() === '' || !Auth::user()->address()) {
                $address = $service->createWallet(Auth::user()->name);
                Auth::user()->currentWallet()->update(['blockio_address' => $address]);
            }
        }

        $myMoneyRequests = Receive::with('From')->where('transaction_state_id', 3)->where('user_id', Auth::user()->id)->get();

        $myEscrows = Escrow::with('toUser')->where('user_id', Auth::user()->id)->where('escrow_transaction_status', '!=', 'completed')->orderby('id', 'desc')->get();
        $toEscrows = Escrow::with('user')->where('to', Auth::user()->id)->where('escrow_transaction_status', '!=', 'completed')->orderby('id', 'desc')->get();

        $transactions = Auth::user()->RecentActivity()->with('Status')->orderby('id', 'desc')->where('type', 'self')->where('transaction_state_id', '!=', 3)->paginate(10);


        $transactionsToConfirm =  Auth::user()->RecentActivity()->with('Status')->orderby('id', 'desc')->where('type', 'self')->where('transaction_state_id', 3)->where('money_flow', '!=', '+')->paginate(10);
        // wallet transaction to cnfirm
        $walletTransactionsToConfirm =  Auth::user()->RecentActivity()->with('Status')->orderby('id', 'desc')->where('type', 'wallet')->where('transaction_state_id', 3)->where('money_flow', '!=', '+')->paginate(10);
        // if($agent->isMobile()){
        //     return view('_mobile.home.index')
        //     ->with('transactions', $transactions)
        //     ->with('transactions_to_confirm', $transactionsToConfirm);
        // }
        return view('home.index')
            ->with('myRequests', $myMoneyRequests)
            ->with('transactions', $transactions)
            ->with('myEscrows', $myEscrows)
            ->with('toEscrows', $toEscrows)
            ->with('transactions_to_confirm', $transactionsToConfirm)
            ->with('wallet_transactions_to_confirm', $walletTransactionsToConfirm);
    }
}
