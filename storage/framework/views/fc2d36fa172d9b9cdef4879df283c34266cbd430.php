
<?php $__env->startSection('styles'); ?>
.hide{
    display:none;
}
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">
        	<div class="card">
            <div class="body">
                <row class="clearfix">
                    <?php if($_ENV['APP_DEMO']): ?>
                        <div class="alert alert-info">
                            <p><strong>Heads up!</strong> Use the above Credit Card for demo testing.</p>
                            <strong>Card Number : </strong> 4242 4242 4242 4242<br>
                            <strong>CVC</strong> 123<br>
                            <strong>Expiration</strong> 10/2021<br>
                        </div>
                    <?php endif; ?>
                    <?php echo $__env->make('flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </row>
                <div class="row">
                    <div class="preview col-lg-4 col-md-12">
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active show" id="product_1">
                            	<img src="<?php echo e(url('/')); ?>/storage/imgs/xNyqTMuGhvfDAQGIpWxfWrz9K49MEpYlvWJgLPeG.jpeg" class="img-fluid">
                            </div>
                            
                        </div>
                                       
                    </div>
                    <div class="details col-lg-8 col-md-12" id="buy_form">
                        <h3 class="product-title m-b-0"><?php echo e(__('Add funds to your wallet with your Credit Card')); ?></h3>                        
                        
                        <div class="card bg-light mt-5">

                            <div class="body">
                                <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
                                <form accept-charset="UTF-8" action="<?php echo e(url('/')); ?>/buyvoucher/stripe" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo e($_ENV['STRIPE_PUBLISHABLE_KEY']); ?>" id="payment-form" method="post">
                                    <?php echo e(csrf_field()); ?>


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
                                             <label class='control-label'> <?php echo e(__('Value')); ?></label> 
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
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>