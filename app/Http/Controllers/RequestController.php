<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Transaction;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function storeRequest(Request $request, $lang){

    	if ($request->has('merchant_key') and $request->has('invoice') and $request->has('currency_code')) {
         
            $invoice = json_decode($request->invoice , true);

            if (is_array($invoice)) {
            	$total = 0 ;
                if (!array_key_exists('return_url', $invoice)) {
                    return response()->json([
                        'status' => false,
                        'error_message' => 'return_url Not Found !, Please provide a return url',
                        'link'  =>  null
                    ]);
                }
                 if (!array_key_exists('cancel_url', $invoice)) {
                    return response()->json([
                        'status' => false,
                        'error_message' => 'cancel_url Not Found !, Please provide a return url',
                        'link'  =>  null
                    ]);
                }
            	if (array_key_exists('items', $invoice) and array_key_exists('invoice_id', $invoice) and array_key_exists('invoice_description', $invoice) and array_key_exists('total', $invoice)) {

            		for ($i = 0 ; $i < count($invoice['items']); $i++) {
            			if (is_array($invoice['items'][$i])) {
            				if (!array_key_exists('name', $invoice['items'][$i])) {
            					return response()->json([
			            			'status' => false,
			            			'error_message' =>'invoice[\'items\']['.$i.'] must have [\'name\'] key ',
			            			'link'	=>	null
			            		]);
            				}
            				if (!array_key_exists('qty', $invoice['items'][$i])) {
            					return response()->json([
			            			'status' => false,
			            			'error_message' => 'invoice[\'items\']['.$i.'] must have [\'qty\'] key ',
			            			'link'	=>	null
			            		]);
            				}
                            if ($invoice['items'][$i]['qty'] <= 0) {
                                return response()->json([
                                    'status' => false,
                                    'error_message' => 'invoice[\'items\']['.$i.'] must have [\'qty\'] greater than 0 ',
                                    'link'  =>  null
                                ]);
                            }
            				if (!array_key_exists('description', $invoice['items'][$i])) {
            					return response()->json([
			            			'status' => false,
			            			'error_message' => 'invoice[\'items\']['.$i.'] must have [\'description\'] key ',
			            			'link'	=>	null
			            		]);
            				}

            				if (!array_key_exists('price', $invoice['items'][$i])) {
            					return response()->json([
			            			'status' => false,
			            			'error_message' =>'invoice[\'items\']['.$i.'] must have [\'price\'] key ',
			            			'link'	=>	null
			            		]);
            				}else{
            					if (!is_numeric($invoice['items'][$i]['price'])) {
            						return response()->json([
				            			'status' => false,
				            			'error_message' =>'invoice[\'items\']['.$i.'][\'price\'] must be a float number Eg: 10.00 ',
				            			'link'	=>	null
				            		]);
            					}
            					if ($invoice['items'][$i]['price'] < 5 ) {
            						return response()->json([
				            			'status' => false,
				            			'error_message' =>'invoice[\'items\']['.$i.'][\'price\'] must be greater than 5.00 ',
				            			'link'	=>	null
				            		]);
            					}
            				}
            				//Exit if statements checks
            			}else{
            				return response()->json([
			            		'status' => false,
			            		'error_message' => 'invoice[\'items\'] key must be an array',
			            		'link'	=>	null
			            	]);
            			}

            			$total += $invoice['items'][$i]['price'] * $invoice['items'][$i]['qty'];
            		}
            	}else{
            		return response()->json([
            			'status' => false,
            			'error_message' =>'invalid invoice array format : array( \'items\' => [ \'item\' => [ ], \'item\' => [ ], \'item\' => [ ]] , \'invoice_id\' =>  \'string\' , \'description\' => \'string\' , \'total\' => \'number\' ) ',
            			'link'	=>	null
            		]);
            	}
            } else{
            	return response()->json([
            		'status' => false,
            		'error_message' => 'invalid invoice array format',
            		'link'	=>	null
            	]);
            }

            if ( $total != $invoice['total']) {
            	return response()->json([
            		'status' => false,
            		'error_message' => 'The total of your items price is not equal to the invoice total',
            		'link'	=>	null
            	]);
            }

            $Merchant = Merchant::with('Currency')->where('merchant_key', $request->merchant_key)->first();

            if ($Merchant->Currency->code != $request->currency_code) {
               return response()->json([
                    'status' => false,
                    'error_message' => 'The Merchant'. $Merchant->name .' only accepts ' .$Merchant->Currency->name .'  ['.$Merchant->Currency->code.'] as payment currency',
                    'link'  =>  null
                ]);
            }

			if ($Merchant == null) {
				return response()->json([
            		'status' => false,
            		'error_message' => 'Merchant Not Found !, Please check your merchant_key and try again',
            		'link'	=>	null
            	]);
			}

			$purchaseRequest = PurchaseRequest::create([
				'ref'	=>	time(),
				'merchant_key'	=>	$request->merchant_key,
                'currency_code' =>  $request->currency_code,
                'currency_id'   =>  $Merchant->Currency->id,
				'data'	=>	$request->invoice,
				'is_expired'	=>	false
			]);

			return response()->json([
        		'status' => true,
        		'success_message' => 'Success !',
        		'link'	=>	url('/').'/'.app()->getLocale().'/merchant/storefront/'.$purchaseRequest->ref
        	]);
        }
        return 'failed';
    }

    public function requestStatus(Request $request, $lang){

        if ($request->has('token') and $request->has('merchant_key')) {
            
            $purchaseRequest = PurchaseRequest::where('ref', $request->token)->first();

            if ($purchaseRequest != NULL) {
                $transaction = Transaction::where('request_id', $purchaseRequest->id)->where('transactionable_type', 'App\Models\Sale')->first();
                
                if($transaction != NULL){

                    $merchant = Merchant::find($transaction->entity_id);

                    if ($merchant != NULL and ($merchant->merchant_key == $request->merchant_key)) {
                       return response()->json([
                            'status' => true,
                            'error_message' =>  NULL,
                            'success_message'   =>  'SUCCESS',
                            'link'  =>  null,
                            'data'  =>  $transaction
                        ]);
                    }
                }
                    
            }
        }
        return response()->json([
            'status' => false,
            'error_message' => 'Invalid Token',
            'link'  =>  null
        ]);   
    }
}
