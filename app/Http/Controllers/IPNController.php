<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Wallet;
use App\Models\Currency;
use App\User;
use App\Models\Purchase;
use App\Models\PurchaseRequest;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IPNController extends Controller
{
   public function pay(Request $request, $lang){
       
       return redirect(route('logandpay', app()->getLocale()));
   }

   public function logandpay (Request $request, $lang){

   

   		 $this->validate($request, [
       		'email' => 'required|string|email|max:255|exists:users,email',
          'password' => 'required|string|min:5',
          'ref' => 'required|numeric'
       ]);

        if ( ! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
           	flash(__('Your email and password do not match our records.'), 'danger');
            return back();
        }

        $merchant = Merchant::with('User')->where('merchant_key',session()->get('PurchaseRequest')->merchant_key)->first();

        if ($merchant == null ) {
            flash(__('Merchant Not Found.'), 'danger');
            return back();
        }

        $PurchaseRequest = PurchaseRequest::where('ref', $request->ref)->first();

        $currency = Currency::where('code', $PurchaseRequest->currency_code)->first();

        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }


        $auth_wallet = Auth::user()->walletByCurrencyId($currency->id);

       if(is_null($auth_wallet)){
            //return redirect(app()->getLocale().'/transfer/methods');
            return redirect(route('show.currencies', app()->getLocale()));
        }

        if((boolean)$currency == false ){
          flash(__('Wops, something went wrong... looks like we do not support this currency. please contact support if this error persists !'), 'danger');
            return back();
        }

        if($PurchaseRequest->Transaction != null){
            flash(__('This purchase request link is already been used. please go back to').' <a class="btn btn-xs btn-danger" href="'.$merchant->site_url.'">'.$merchant->name.'</a>'.__('and try to purchase again !') , 'danger');
            return back();
        }


        if($PurchaseRequest == null){
          flash(__('Woops... Something went wrong !') , 'danger');
          return back();
        }

        if ( Auth::user()->account_status == 0 ) {
            flash(__('Your account is under a withdrawal request review proccess. please wait for a few minutes and try again') , 'info');
             return  back();
        }

        
        if( Auth::user()->id == $merchant->User->id ){
        	
        	Auth::logout();

        	flash(__('You are logging into the account of the seller for this purchase. Please change your login information and try again.') , 'danger');
             return  back();
        }

        if(  $auth_wallet->amount < (float)session()->get('PurchaseRequestTotal') ){
        	
        	Auth::logout();

        	flash(__('You have insufficient funds in your ') .$currency->name. __(' wallet to proceed with this purchase.'), 'danger');
            return  back();
        }

        $purchase_fee = 0; //free buy with your phpWallet credit
        

        $sale_fee = bcadd( bcmul(''.( setting('merchant.merchant_percentage_fee')/100), ''.session()->get('PurchaseRequestTotal'), $precision) , setting('merchant.merchant_fixed_fee'), $precision ) ; 

        if( $currency->is_crypto == 1 ){

            $sale_fee = bcmul(''.( setting('merchant.merchant_percentage_fee')/100), ''.session()->get('PurchaseRequestTotal'), $precision) ; 
        }

        $minimum = (float)session()->get('PurchaseRequestTotal') + (float) $sale_fee;

        if ((float)session()->get('PurchaseRequestTotal') - $sale_fee <= 0 ) {
            
            flash(__('We only support invoices with a total greater than ').$minimum.$currency->symbol, 'danger');
            return  back();
        }
        
        $sale = Sale::create([
          'user_id' =>  $merchant->User->id,
          'merchant_id' =>  $merchant->id, 
          //'purchase_id' =>  0,
          'transaction_state_id'  =>  1,
          'gross' =>  (float)session()->get('PurchaseRequestTotal'),
          'fee' =>  $sale_fee, 
          'net' =>  bcsub( '' . session()->get('PurchaseRequestTotal') , $sale_fee, $precision ),
          'currency_id' =>  $currency->id,
          'currency_symbol' =>  $currency->symbol,
          'json_data' =>  json_encode($PurchaseRequest->data)
        ]);

        $purchase = Purchase::create([
          'user_id' =>  Auth::user()->id,
          'merchant_id' =>  $merchant->id, 
          'sale_id' =>  $sale->id,
          'transaction_state_id'  =>  1,
          'currency_id' =>  $currency->id,
          'currency_symbol' =>  $currency->symbol,
          'gross' =>  (float)session()->get('PurchaseRequestTotal'),
          'fee' =>  $purchase_fee,
          'net' =>  bcsub( ''.session()->get('PurchaseRequestTotal') , $purchase_fee, $precision ),
          'json_data' =>  json_encode($PurchaseRequest->data)
        ]);

        $merchant->User->RecentActivity()->save($sale->Transactions()->create([
            'user_id' => $sale->user_id,
            'entity_id'   =>  $merchant->id,
            'entity_name' =>  $merchant->name,
            'transaction_state_id'  =>  3, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'thumb' =>  $purchase->User->avatar(),
            'activity_title'    =>  'Sale',
            'gross' =>  $sale->gross,
            'fee'   =>  $sale->fee,
            'net'   =>  $sale->net,
            'request_id'  =>  $PurchaseRequest->id,
            'json_data' =>  json_encode($PurchaseRequest->data),
        ]));

        Auth::user()->RecentActivity()->save($purchase->Transactions()->create([
            'user_id' =>  Auth::user()->id,
            'entity_id'   =>  $merchant->id,
            'entity_name' =>  $merchant->name,
            'transaction_state_id'  =>  3, // waiting confirmation
            'money_flow'    => '-',
            'activity_title'    =>  'Purchase',
            'currency_id' =>  $currency->id,
            'thumb' =>  $merchant->logo,
            'currency_symbol' =>  $currency->symbol,
            'gross' =>  $purchase->gross,
            'fee'   =>  $purchase->fee,
            'net'   =>  $purchase->net,
            'request_id'  =>  $PurchaseRequest->id,
            'json_data' =>  json_encode($PurchaseRequest->data)
        ]));


        return  redirect(route('home', app()->getLocale()));


        //return redirect('home');
   }

  public function purchaseConfirmation(Request $request, $lang){
        
        $this->validate($request,[
          'tid' => 'required|numeric'
        ]);

        $transaction = Transaction::findOrFail($request->tid);

        $currency = Currency::find($transaction->currency_id);

        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $auth_wallet = Auth::user()->walletByCurrencyId($currency->id);

        if((boolean)$currency == false ){
          flash(__('Wops, something went wrong... looks like we do not support this currency. please contact support if this error persists !'), 'danger');
            return back();
        }

        if (Auth::user()->currentCurrency()->id != $currency->id ) {

          $CurrentUser = Auth::user();
          $CurrentUser->currency_id = $currency->id;
          $CurrentUser->save();

          // flash(__('Wops, something went wrong... please change your wallet to ').$currency->name. __(' to proceed with this transaction, contact support if this error persists !'), 'danger');

          flash(__('Something Went Wrong. Please Try to confirm this payment one more time'));

          return back();
        }

        $purchaseRequest = PurchaseRequest::findOrFail($transaction->request_id);

        if ( $transaction->created_at < Carbon::now()->subMinutes(5)->toDateTimeString()) {
         flash(__('The purchase transaction you are trying to confirm was created ').$transaction->created_at->diffForHumans().__(' and at this time the item may not exist in the stock.<br> Please, delete this transaction, go back to ') .$transaction->entity_name.'\'s'. __(' site and try again'), 'warning');
            return back();
        }

        if((boolean)$transaction == false ){
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

         if ( Auth::user()->account_status == 0 ) {
            flash(__('Your account is under a withdrawal request review proccess. please wait for a few minutes and try again') , 'info');
             return  back();
        }
        
        if(Auth::user()->id != $transaction->user_id ){
            flash(__('Wops, something went wrong... please contact support if this error persists !'),'danger');
            return back();
        }

        $purchase = Purchase::find($transaction->transactionable_id);

         if((boolean)$purchase == false ){
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        if(Auth::user()->id != $purchase->user_id ){
            flash(__('Wops, something went wrong... please contact support if this error persists !'),'danger');
            return back();
        }

        $sale = Sale::find($purchase->sale_id);

        if((boolean)$sale == false ){
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        $user = User::find($sale->user_id);

        $user_wallet = $user->walletByCurrencyId($currency->id);

        if((boolean)$user == false ){
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        $sale_transaction = transaction::where('transactionable_type', 'App\Models\Sale')->where('user_id', $user->id)->where('transaction_state_id', 3)->where('money_flow', '+')->where('transactionable_id', $sale->id)->first();

        if((boolean)$sale_transaction == false ){
            flash(__('Wops, something went wrong... please contact support if this error persists !'), 'danger');
            return back();
        }

        if((float)$auth_wallet->amount < (float)$transaction->net ){
              flash(__('You have insufficient funds in you ').$currency->name.__(' wallet to proceed with this purchase.'), 'danger');
            return  back();
        }

        $sale->purchase_id = $purchase->id;
        $sale->transaction_state_id = 1;
        $sale->save();

        $purchase->transaction_state_id = 1;
        $purchase->save();

        $transaction->transaction_state_id = 1;
        $transaction->balance = bcsub($auth_wallet->amount , $transaction->net, $precision );
        $transaction->save();

        $sale_transaction->transaction_state_id = 1;
        $sale_transaction->balance =  bcadd( $user_wallet->amount , $sale_transaction->net, $precision );
        $sale_transaction->save();

        $auth_wallet->amount = bcsub($auth_wallet->amount ,$transaction->net, $precision ) ;
        $auth_wallet->save();

        $user_wallet->amount = bcadd( $user_wallet->amount , $sale_transaction->net, $precision ) ;
        $user_wallet->save();

        $this->sendIpnNotification($transaction);

        //flash('Transaction Complete !', 'success');

        Auth::logout();

        //return redirect($purchaseRequest->data->return_url.'token='.$purchaseRequest->ref);
        return redirect(  http_build_url($purchaseRequest->data->return_url, array("query" => "token=$purchaseRequest->ref"), HTTP_URL_JOIN_QUERY));

        //return  back();
  }
  public function purchaseCancelation(Request $request, $lang){
        
        $this->validate($request,[
          'tid' => 'required|numeric'
        ]);

        $transaction = Transaction::findOrFail($request->tid);
        
        $purchase = Purchase::findOrFail($transaction->transactionable_id);
        
        $sale = Sale::findOrFail($purchase->sale_id);

        $sale->delete();
        $purchase->delete();
        $transaction->delete();

        
        return  back();
  }

  private function sendIpnNotification(Transaction $transaction){

    $merchant = Merchant::find($transaction->entity_id);

    $post = array(
      'transaction'=> $transaction
      );

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $merchant->success_link );
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

      $response = json_decode(curl_exec($ch),true);

      curl_close($ch);
  }



}
