<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investmentplan;
use App\Models\Investment;
use App\Models\Wallet;
use Auth;

class InvestmentController extends Controller
{
    public function plans(Request $request, $lang)
    {
    	$plans = Investmentplan::with('TransferMethod')->orderBy('id', 'asc')->paginate(10);
    	if($plans->total() === 0){
    		dd('No investment plans available at the moment');
    	}
    	
    	return view('investment.plans')->with('plans', $plans);

    }

    public function investForm(Request $request, $lang, $planid)
    {
        $plan = Investmentplan::findOrFail($planid);

        return view('investment.invest')->with('plan', $plan);
    }

    public function store(Request $request, $lang)
    {

        $this->validate($request, [
            'capital' => 'required|numeric',
            'plan_id' => 'required|numeric|exists:investmentplans,id'
        ]);

        $user = Auth::user();

        $plan = Investmentplan::with('TransferMethod')->where('id', $request->plan_id)->with('TransferMethod')->first();
        
        $wallet = Wallet::where('currency_id', $plan->TransferMethod->currency_id)->where('user_id', $user->id)->first();

        if(is_null($wallet)){
            flash(__('Looks like you are trying to invest') . ' '. $plan->TransferMethod->currency->name . __('and you do not have a wallet with this currency, please register a wallet first') , 'danger');
            return back();
        }

        //check if wallet can afford capital
        if($wallet->amount < $request->capital){
            flash(__('Your wallet cant afford this investment'), 'danger');
            return back();
        }
        //check if capital in betwiin maximum and minimum plan investment
        if($request->capital < $plan->min_investment){
            flash(__('The capital you have provided is less than the minimum investment required for this plan') . ' ' .(float)$plan->min_investment . $plan->TransferMethod->currency->code, 'danger');
            return back();
        }

         if($request->capital > $plan->max_investment){
            flash(__('The capital you have provided passed the maximum investment allowed in this plan'). ' ' .(float)$plan->max_investment . $plan->TransferMethod->currency->code, 'danger');
            return back();
        }

        //check if wallet is crypto or fiat to evaluate precision
        if ( $plan->TransferMethod->currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }
        //subtaract capital from wallet

        $wallet->amount = bcsub($wallet->amount ,$request->capital, $precision ) ;
        
        //create new investment with capital

        $investment = Investment::create([
            'user_id' => $user->id,
            'investmentplan_id' => $plan->id,
            'capital'   =>  $request->capital,
            'is_crypto' => $wallet->is_crypto,
            'start' => \Carbon\Carbon::now(),
            'end'   => \Carbon\Carbon::now()->addDays($plan->withdraw_interval_days+3),//add plan days
            'status'    => 1,

        ]);
        //create a transaactioin for user investment

        $user->RecentActivity()->save($investment->Transactions()->create([
            'user_id' => $user->id,
            'entity_id'   =>  $user->id,
            'entity_name' =>   $plan->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '-',
            'activity_title'    =>  'Investment',
            'balance'   =>   $wallet->amount,
            'currency_id'   =>  $plan->transferMethod->currency->id,
            'currency_symbol'   =>  $plan->transferMethod->currency->symbol,
            'thumb' => $plan->transferMethod->currency->thumb,
            'gross' =>  $investment->capital,
            'fee'   =>  0,
            'net'   =>  $investment->capital
        ]));
        //save wallet
        //save investment

        $wallet->save();
        $user->save();

        return redirect(app()->getLocale().'/home');

    }

    public function takeProfit(Request $request, $lang){

        $this->validate($request, [
            'inv_id' => 'required|numeric|exists:investments,id'
        ]);


        $user = Auth::user();

        $investment = Investment::with('Plan')->where('id', $request->inv_id)->where('user_id', $user->id)->first();

        $now = \Carbon\Carbon::now();
        $days = $now->diffInDays($investment->end);


        // should be >=
        if($days <= 0){
            flash(__('Your investment did not elapsed, please wait until the elapse date to take profits.'), 'danger');
            return back();
        }

        if($investment->status == 0){
            flash(__('The profits for this investment have already been taken, please start a new investment'), 'danger');
            return back();
        }

        if(is_null($investment)){
            flash(__('Whoops, something went wrong, please contact support.'), 'danger');
            return back();
        }

        $plan = Investmentplan::with('TransferMethod')->where('id', $investment->investmentplan_id)->with('TransferMethod')->first();
        
        $wallet = Wallet::where('currency_id', $plan->TransferMethod->currency_id)->where('user_id', $user->id)->first();

        $investment->status = 0;

        if ( $plan->TransferMethod->currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $withdraw_amount = bcadd( $investment->capital , $investment->earnings, $precision );

        $wallet->amount =  bcadd( $wallet->amount , $withdraw_amount, $precision );

        $user->RecentActivity()->save($investment->Transactions()->create([
            'user_id' => $user->id,
            'entity_id'   =>  $user->id,
            'entity_name' =>   $plan->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'activity_title'    =>  'Investment profits',
            'balance'   =>   $wallet->amount,
            'currency_id'   =>  $plan->transferMethod->currency->id,
            'currency_symbol'   =>  $plan->transferMethod->currency->symbol,
            'thumb' => $plan->transferMethod->currency->thumb,
            'gross' =>  $withdraw_amount,
            'fee'   =>  0,
            'net'   =>  $withdraw_amount
        ]));
        $investment->save();
        $user->save();
        $wallet->save();

        return redirect(app()->getLocale().'/home');

    }

    public function myInvestments(Request $request, $lang)
    {

        $investments = Investment::with('Plan')->where('user_id', Auth::user()->id)->paginate(10);

        return view('investment.myinvestments')->with('investments', $investments);
        

    }
}
