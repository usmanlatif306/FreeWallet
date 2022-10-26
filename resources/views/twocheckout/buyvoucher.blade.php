@extends('layouts.app')
@section('styles')
.hide{
    display:none;
}
@endsection
@section('content')
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
        	<div class="card">
            <div class="body">
                <row class="clearfix">
                    @if($_ENV['APP_DEMO'])
                        <div class="alert alert-info">
                            <p><strong>Heads up!</strong> Use the above Credit Card for demo testing.</p>
                            <strong>Card Number : </strong> 4242 4242 4242 4242<br>
                            <strong>CVC</strong> 123<br>
                            <strong>Expiration</strong> 10/2021<br>
                        </div>
                    @endif
                    @include('flash')
                </row>
                <div class="row">
                    <div class="preview col-lg-4 col-md-12">
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active show" id="product_1">
                            	<img src="{{url('/')}}/storage/imgs/xNyqTMuGhvfDAQGIpWxfWrz9K49MEpYlvWJgLPeG.jpeg" class="img-fluid">
                            </div>
                            
                        </div>
                                       
                    </div>
                    <div class="details col-lg-8 col-md-12" id="buy_form">
                        <h3 class="product-title m-b-0">{{__('Add funds to your wallet with your Credit Card') }}</h3>                        
                        
                        <div class="card bg-light mt-5">

                            <div class="body">
                                <script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
                                <form accept-charset="UTF-8" action="{{url('/')}}/{{app()->getLocale()}}/buyvoucher/2checkout" class="require-validation" id="payment-Frm" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="email" value="{{Auth::user()->email}}" id="email" placeholder="Enter email" required>
                                     <input id="token" name="token" type="hidden" value="">
                                    <div class='form-row'>
                                        <div class='col form-group required'>
                                            <label class='control-label'>Name on Card</label> <input
                                                class='form-control' name="name" id="name" type='text'>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col form-group  required'>
                                            <label class='control-label'>Card Number</label> <input
                                                autocomplete='off' class='form-control card-number' size='20'
                                                type='text' name="card_num" id="card_num">
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col form-group cvc required'>
                                            <label class='control-label'>CVC</label> <input autocomplete='off'
                                                class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                type='text'  name="cvv" id="cvv" >
                                        </div>
                                        <div class='col form-group expiration required'>
                                            <label class='control-label'>Expiration Month</label> <input
                                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                                type='text' name="exp_month" id="exp_month">
                                        </div>
                                        <div class='col form-group expiration required'>
                                            <label class='control-label'>Expiration Year </label> <input
                                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                type='text' name="exp_year" id="exp_year">
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col'>
                                             <label class='control-label'> {{__('Value')}}</label> 
                                            <input type="number" value="1" name="amount" aria-label="Search" class="form-control" v-on:keyup="totalize"  v-on:change="totalize" >
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col form-group'>
                                            <button class='form-control btn btn-primary submit-button'
                                                type='submit' style="margin-top: 10px;">ADD FUNDS</button>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col error form-group hide'>
                                            <div class='alert-danger alert'>Please correct the errors and try
                                                again.</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    
@endsection
@section('js')
    <script>
// Called when token created successfully.
var successCallback = function(data) {
    console.log(data);
  var myForm = document.getElementById('paymentFrm');
  
  // Set the token as the value for the token input
  myForm.token.value = data.response.token.token;
  
  // Submit the form
  myForm.submit();
};

// Called when token creation fails.
var errorCallback = function(data) {
    console.log(data);
  if (data.errorCode === 200) {
    tokenRequest();
  } else {
    alert(data.errorMsg);
  }
};

var tokenRequest = function() {
  // Setup token request arguments
  var args = {
    sellerId: "{{$_ENV['2CHECKOUT_MERCHANT_CODE']}}",
    publishableKey: "{{$_ENV['2CHECKOUT_PUBLISHABLE_KEY']}}",
    ccNo: $("#card_num").val(),
    cvv: $("#cvv").val(),
    expMonth: $("#exp_month").val(),
    expYear: $("#exp_year").val()
  };
  
  // Make the token request
  TCO.requestToken(successCallback, errorCallback, args);
};

$(function() {
  // Pull in the public encryption key for our environment
  TCO.loadPubKey('sandbox');
  
  $("#paymentFrm").submit(function(e) {
    // Call our token request function
    tokenRequest();
   
    // Prevent form from submitting
    return false;
  });
});
</script>
@endsection


@section('footer')
  @include('partials.footer')
@endsection