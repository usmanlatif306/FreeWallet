<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Sale;
use App\Models\Voucher;
use App\Models\Wallet;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\PurchaseRequest;

class PaystackController extends Controller
{
	private $SECRET_KEY; 

	public function __construct()
	{
		$this->SECRET_KEY = "sk_test_170eded692183972be3b4c35b24bfe2a9f7ce284";
	}

	public function buyvoucher(Request $request, $lang){

		$user = Auth::user();
        $user->currency_id = 10;
        $user->save();
        return view('paystack.buyvoucher');
    }
   
   	public function payVoucherPayStackSuccess(Request $request, $lang)
    {	
    	$curl = curl_init();
		$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
		if(!$reference){
		  die('No reference supplied');
		}

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_HTTPHEADER => [
		    "accept: application/json",
		    "authorization: Bearer $this->SECRET_KEY",
		    "cache-control: no-cache"
		  ],
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		if($err){
			// there was an error contacting the Paystack API
		  die('Curl returned error: ' . $err);
		}

		$tranx = json_decode($response);

		if(!$tranx->status){
		  // there was an error from the API
		  die('API returned error: ' . $tranx->message);
		}

		if( 'success' == $tranx->data->status ){

		  	$wallet = Auth::user()->currentWallet() ;
	   		$fee = (float)($tranx->data->fees/100) ;
	   		$voucherValue = (float)(( $tranx->data->amount - $tranx->data->fees )/100);

	   		$voucher = Voucher::create([
	            'user_id'   =>  Auth::user()->id,
	            'voucher_amount'    =>  ($tranx->data->amount/100),
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
	            'currency_id' =>  $voucher->currency_id,
	            'currency_symbol' =>  $voucher->currency_symbol,
	            'gross' =>  ($tranx->data->amount/100),
	            'fee'   =>  $fee,
	            'thumb'	=>	$wallet->currency->thumb,
	            'net'   =>  $voucherValue,
	            'balance'	=>	$wallet->amount,
	        ]));

	        return redirect(app()->getLocale().'/home');
		}
    	
    }

    public function sendRequestToPayStack(Request $request, $lang)
    {

        $this->validate($request,[
            'amount'  =>  'required|integer|min:1',
        ]);
        
        $value = $request->amount .= '00';

        $curl = curl_init();
		$email = Auth::user()->email;
		$amount = (int)$value ;  //the amount in kobo. This value is actually NGN 300

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode([
		    'amount'=>$amount,
		    'email'=>$email,
		    'callback_url'=>url('/').'/'.app()->getLocale().'/pay/voucher/paystack/success',
		  ]),
		  CURLOPT_HTTPHEADER => [
		    "authorization: Bearer $this->SECRET_KEY", //replace this with your own test key
		    "content-type: application/json",
		    "cache-control: no-cache"
		  ],
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		if($err){
		  // there was an error contacting the Paystack API
		  die('Curl returned error: ' . $err);
		}

		$tranx = json_decode($response, true);

		if(!$tranx['status'] != true ){
		  // there was an error from the API
		  print_r('API returned error: ' . $tranx['message']);
		}

		// comment out this line if you want to redirect the user to the payment page
		//print_r($tranx);

		// redirect to page so User can pay
		// uncomment this line to allow the user redirect to the payment page
		header('Location: ' . $tranx['data']['authorization_url']);
    }

    public function postStoreFront(Request $request, $lang){
    	//dd($request);


    	$this->validate($request,	[
    		'ref'	=>	'required',
    	]);

    	$sale_fee = ((setting('merchant.merchant_percentage_fee')/100)* (float)session()->get('PurchaseRequestTotal')) + setting('merchant.merchant_fixed_fee') ; 

        $minimum = (float)session()->get('PurchaseRequestTotal') +  $sale_fee;

        if ((float)session()->get('PurchaseRequestTotal') - $sale_fee <= 0 ) {
            
            flash(__('We only support invoices with a total greater than ').$minimum.$currency->symbol, 'danger');
            return  back();
        }

    	$PurchaseRequest = PurchaseRequest::with('Transaction')->with('Currency')->where('ref', $request->ref)->first();

        if($PurchaseRequest == null)
        return abort(404); 

    	if ($PurchaseRequest->Currency->id != 10) {
    		dd('Paystack only supports Nigerian Naira ( NGN ). Please Return back and use Paypal or Stripe');
    	}

    	if ( ( $PurchaseRequest != null and $PurchaseRequest->is_expired == false ) or session()->has('PurchaseRequest')) {
            $total = 0;

            $merchant = Merchant::where('merchant_key', $PurchaseRequest->merchant_key)->first();
            
            if($merchant == null)
            return abort(404);
            $data['items'] = [];
            foreach ($PurchaseRequest->data->items as $item) {
            	array_push($data['items'], (array) $item);
               	$total += ( $item->price * $item->qty );
            }

            /*
            $PayPalHandlingFee = (( $total * 4.4 ) / 100 ) + 2 ;

            $total += $PayPalHandlingFee ;
           
            array_push($data['items'], [ "name" => "handling fee", "price" => $PayPalHandlingFee , "qty" => 1, "description" => "PayPal handling fee ( 4.4% + 2$ ) " ]);
			*/

			
            $value = $total .= '00';

	        $curl = curl_init();
			$email = $merchant->user->email;
			$amount = (int)$value ;  //the amount in kobo. This value is actually NGN 300

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode([
			    'amount'=>$amount,
			    'email'=>$email,
		    	'callback_url'	=>	url('/').'/'.app()->getLocale().'/merchant/storefront/paystack/success?ref='.$PurchaseRequest->ref,
			  ]),
			  CURLOPT_HTTPHEADER => [
			    "authorization: Bearer $this->SECRET_KEY", //replace this with your own test key
			    "content-type: application/json",
			    "cache-control: no-cache"
			  ],
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			if($err){
			  // there was an error contacting the Paystack API
			  die('Curl returned error: ' . $err);
			}

			$tranx = json_decode($response, true);

			if(!$tranx['status'] != true ){
			  // there was an error from the API
			  print_r('API returned error: ' . $tranx['message']);
			}

			// comment out this line if you want to redirect the user to the payment page
			//print_r($tranx);


			// redirect to page so User can pay
			// uncomment this line to allow the user redirect to the payment page
			header('Location: ' . $tranx['data']['authorization_url']);

	        //return redirect($response['paypal_link']);
        }
    }

	public function postStoreFrontSuccess(Request $request, $lang){

		$curl = curl_init();
		$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
		if(!$reference){
		  die('No reference supplied');
		}

		$PurchaseRequest = PurchaseRequest::with('Transaction')->with('Currency')->where('ref', $request->ref)->first();
		$currency = Currency::where('code', $PurchaseRequest->currency_code)->first();
        if($PurchaseRequest == null)
        return abort(404); 

    	
	    if( $PurchaseRequest->is_expired == true ){
	    	return abort(404); 
        }

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_HTTPHEADER => [
		    "accept: application/json",
		    "authorization: Bearer $this->SECRET_KEY",
		    "cache-control: no-cache"
		  ],
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		if($err){
			// there was an error contacting the Paystack API
		  die('Curl returned error: ' . $err);
		}

		$tranx = json_decode($response);

		if(!$tranx->status){
		  // there was an error from the API
		  die('API returned error: ' . $tranx->message);
		}

		if( 'success' == $tranx->data->status ){

			$fee = (float)($tranx->data->fees/100) ;
	   		$net = (float)(( $tranx->data->amount - $tranx->data->fees )/100);
	   		$gross = (float)($tranx->data->amount);
		  		
       		$merchant = Merchant::with('User')->where('merchant_key',session()->get('PurchaseRequest')->merchant_key)->first();

       		$wallet = Wallet::where('user_id', $merchant->User->id)->where('currency_id', $currency->id)->first();

       		$sale_fee = ((setting('merchant.merchant_percentage_fee')/100)* (float)session()->get('PurchaseRequestTotal')) + setting('merchant.merchant_fixed_fee') ; 
       		
       		$wallet->amount = $wallet->amount + $net ;

	    	$wallet->save();



       		$sale = Sale::create([
	          'user_id' =>  $merchant->User->id,
	          'merchant_id' =>  $merchant->id, 
	          'purchase_id' =>  0,
	          'transaction_state_id'  =>  1,
	          'gross' =>  $gross,
	          'fee' =>  $fee, 
	          'net' =>  $net,
	          'currency_id' =>  $currency->id,
	          'currency_symbol' =>  $currency->symbol,
	          'json_data' =>  json_encode($PurchaseRequest->data)
	        ]);

	        $merchant->User->RecentActivity()->save($sale->Transactions()->create([
	            'user_id' => $sale->user_id,
	            'entity_id'   =>  $merchant->id,
	            'entity_name' =>  $merchant->name,
	            'transaction_state_id'  =>  1, // waiting confirmation
	            'money_flow'    => '+',
	            'currency_id' =>  $currency->id,
	            'currency_symbol' =>  $currency->symbol,
	            'thumb' =>  url('/').'/storage/imgs/smOMNQbvaoIgP8Y2TcA6DfgAdVdWsXe1Caww3aYV.png',
	            'activity_title'    =>  'Sale',
	            'gross' =>  $sale->gross,
	            'fee'   =>  $sale->fee,
	            'net'   =>  $sale->net,
	            'balance'	=>	$wallet->amount,

	            'request_id'  =>  $PurchaseRequest->id,
	            'json_data' =>  json_encode($PurchaseRequest->data),
	        ]));

	        return redirect( http_build_url($PurchaseRequest->data->return_url, array("query" => "token=$PurchaseRequest->ref"), HTTP_URL_JOIN_QUERY));
		}
	}


    private function Money($value)
    {
    	return number_format((float)$value, 2, '.', '');
    }

}
