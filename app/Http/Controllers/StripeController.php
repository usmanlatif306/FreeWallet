<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Voucher;
use App\Models\Wallet;
use App\Models\Currency;
use \Stripe\Stripe;
use Illuminate\Http\Request;

class StripeController extends Controller
{
     public function buyvoucher(Request $request, $lang){
    	$user = Auth::user();
        $user->currency_id = 1;
        $user->save();
        return view('stripe.buyvoucher');
    }

    public function sendRequestToStripe(Request $request, $lang){
    	  $this->validate($request,[
            'amount'  =>  'required|integer|min:1',
            'stripeToken'	=>	'required'
        ]);

    	$fee = (( $request->amount * 3.99 ) / 100 ) + 0.5 ;
    	$amount_without_fees = $request->amount - $fee ;

    	Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

    	// Stipe fee 3.99% + R$0.50;


    	try{
	    	\Stripe\Charge::create([
	    		'amount'	=>	$request->amount * 100,
	    		'currency'	=>	'usd',
	    		'source'	=>	$request->stripeToken,
	    		'description'	=>	'sample discription',

	    	]);

	    	$wallet = Auth::user()->currentWallet() ;
		           		
       		$voucherValue = (float)$amount_without_fees;

       		$voucher = Voucher::create([
	            'user_id'   =>  Auth::user()->id,
	            'voucher_amount'    =>  $request->amount,
	            'voucher_fee'   =>  $fee,
	            'voucher_value' =>  $voucherValue,
	            'voucher_code'  =>  Auth::user()->id.str_random(4).time().str_random(4),
	            'currency_id'   =>  $wallet->currency->id,
	            'currency_symbol'   =>  $wallet->currency->symbol,
	            'wallet_id' =>  $wallet->id
	        ]);

	        $wallet->amount = $wallet->amount + $voucherValue ;

	    	$voucher->user_loader = Auth::user()->id;
	    	
	    	$voucher->is_loaded = 1 ;

	    	$voucher->save();

	    	$wallet->save();

	        Auth::user()->RecentActivity()->save($voucher->Transactions()->create([
	            'user_id' =>  Auth::user()->id,
	            'entity_id'   =>  $voucher->id,
	            'entity_name' =>  $wallet->currency->name,
	            'transaction_state_id'  =>  1, // waiting confirmation
	            'money_flow'    => '+',
	            'activity_title'    =>  'Voucher Load',
	            'thumb'	=>	$wallet->currency->thumb,
	            'currency_id' =>  $voucher->currency_id,
	            'currency_symbol' =>  $voucher->currency_symbol,
	            'gross' =>  $request->amount,
	            'fee'   =>  $fee,
	            'net'   =>  $voucherValue,
	            'balance'	=>	$wallet->amount,
	        ]));

    		flash('Payment Success');
    		return redirect(app()->getLocale().'/home');

    	}catch(\Exception $e){
    		dd($e);
    	}
    }
}
