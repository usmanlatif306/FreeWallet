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
                                <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
                                <form accept-charset="UTF-8" action="{{url('/')}}/{{app()->getLocale()}}/buyvoucher/stripe" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{$_ENV['STRIPE_PUBLISHABLE_KEY']}}" id="payment-form" method="post">
                                    {{ csrf_field() }}

                                    <div class='form-row'>
                                        <div class='col form-group required'>
                                            <label class='control-label'>Name on Card</label> <input
                                                class='form-control' size='4' type='text'>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col form-group  required'>
                                            <label class='control-label'>Card Number</label> <input
                                                autocomplete='off' class='form-control card-number' size='20'
                                                type='text'>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='col form-group cvc required'>
                                            <label class='control-label'>CVC</label> <input autocomplete='off'
                                                class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                type='text'>
                                        </div>
                                        <div class='col form-group expiration required'>
                                            <label class='control-label'>Expiration Month</label> <input
                                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                                type='text'>
                                        </div>
                                        <div class='col form-group expiration required'>
                                            <label class='control-label'>Expiration Year </label> <input
                                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                type='text'>
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
        $(function() {
              $('form.require-validation').bind('submit', function(e) {
                var $form         = $(e.target).closest('form'),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                                     'input[type=text]', 'input[type=file]',
                                     'textarea'].join(', '),
                    $inputs       = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid         = true;
                $errorMessage.addClass('hide');
                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                  var $input = $(el);
                  if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault(); // cancel on first error
                  }
                });
              });
            });
            $(function() {
              var $form = $("#payment-form");
              $form.on('submit', function(e) {
                if (!$form.data('cc-on-file')) {
                  e.preventDefault();
                  Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                  Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                  }, stripeResponseHandler);
                }
              });
              function stripeResponseHandler(status, response) {
                if (response.error) {
                  $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
                } else {
                  // token contains id, last4, and card type
                  var token = response['id'];
                  // insert the token into the form so it gets submitted to the server
                  $form.find('input[type=text]').empty();
                  $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                  $form.get(0).submit();
                }
              }
            })
        </script>
@endsection


@section('footer')
  @include('partials.footer')
@endsection