<?php $__env->startSection('content'); ?>

<div class="row">
    <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="col-md-9 " style="padding-right: 0" id="#addFund">
        <?php echo $__env->make('flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="card">
            <div class="header">
                <h2><strong><?php echo e(__('Add')); ?></strong> <?php echo e(__("Fund")); ?></h2>

            </div>
            <div class="body">
                <form action="<?php echo e(route('addFunds', app()->getLocale())); ?>" method="post" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <?php if(Session::has('success')): ?>
                        <div class="col-12">
                            <div class="alert alert-success mx-1">
                                <?php echo e(Session::get('success')); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(Session::has('error')): ?>
                        <div class="col-12">
                            <div class="alert alert-danger mx-1">
                                <?php echo e(Session::get('error')); ?>

                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(!auth()->user()->identified): ?>
                        <div class="col-12 mb-3">
                            <div class="alert alert-danger mx-1">
                                Your identify is not verified yet. Kindly verified your identity to add funds. To verify
                                your identity <a href="<?php echo e(route('identity.index', app()->getLocale())); ?>">click here</a>.
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="form-group <?php echo e($errors->has('card') ? ' has-danger' : ''); ?>">
                                <label for="amount"><?php echo e(__('Amount')); ?></label>
                                <input type="number" id="amount" class="form-control" name="amount" required placeholder="Amount" value="<?php echo e(old('amount')); ?>">
                                <div id="message" class="text-primary">
                                    <small>Your enter amount will be converted to your wallet currency on today's
                                        rate.</small>
                                </div>
                                <div id="error" class="form-control-feedback text-danger d-none">
                                    Please enter valid amount
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="currency"><?php echo e(__('Currency')); ?></label>
                                <select name="currency" id="currency" class="form-control z-index show-tick" value="<?php echo e(old('currency')); ?>">
                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix border-bottom mt-3 mb-2"></div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" style="border-radius: 30px;" class="btn btn-primary" value="<?php echo e(__('Proceed')); ?>" <?php echo e(auth()->user()->identified ? '' : 'disabled'); ?> data-key="<?php echo e(config('services.stripe.key')); ?>" data-amount="" data-currency="usd" data-locale="auto" data-name="<?php echo e(setting('site.site_name')); ?>" data-description="Pay with Stripe to charge wallet" data-image="http://freewallets.co/storage/imgs/fav-icon.png" />
                            <!-- <input type="submit" class="btn btn-primary" value="<?php echo e(__('Proceed')); ?>"
                                data-key="<?php echo e(config('services.stripe.key')); ?>" data-amount="" data-currency="usd"
                                data-locale="auto" data-name="<?php echo e(setting('site.site_name')); ?>"
                                data-description="Pay with Stripe to charge wallet"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png" /> -->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
    $(function() {
        $('#currency').on('change', function(e) {
            $(':submit').data('currency', e.target.value)
        });
        $(':submit').on('click', function(event) {
            event.preventDefault();
            $('#error').addClass('d-none');
            var amount = $('#amount').val();
            if (amount) {
                $(this).data('amount', amount * 100);
                var $button = $(this),
                    $form = $button.parents('form');
                var opts = $.extend({}, $button.data(), {
                    token: function(result) {
                        $form.append($('<input>').attr({
                            type: 'hidden',
                            name: 'stripeToken',
                            value: result.id
                        })).submit();
                    }
                });
                StripeCheckout.open(opts);
            } else {
                $('#error').removeClass('d-none');
            }

        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>