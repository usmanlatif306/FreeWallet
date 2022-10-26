<div class="col-10 col-lg-push-1" style="margin-top: 20px">
    <div class="card card-primary">
        
        <div class="body">
            <div class="row">
                <div class="col">
                    <div class="media">
                        <div>
                            <div class="thumb hidden-sm m-r-20"> <img src="<?php echo e($merchant->logo); ?>" class="rounded-circle" alt="" style="width: 40px;"> </div>
                        </div>
                        <div class="media-body">
                            <div class="media-heading " style="margin-top: 10px !important;">
                                <span><?php echo e($merchant->name); ?> </span>
                                <span class="badge badge-info">Merchant</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="mb-5 mt-5"><?php echo e(__('Your Invoice')); ?></h4> 
                        <?php echo $__env->make('merchant.invoice', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                     
                    <div class="row">
                        <div class="col">
                             <div class="mb-5 mt-2" style="padding: 20px 80px;">
                                <h4 style="text-align: center;"><?php echo e(setting('site.site_name')); ?> <?php echo e(__('is the faster, safer way to pay in the internet')); ?></h4>
                                    <p style="text-align: center;"> <?php echo e(__('No matter where you shop, we keep your financial information secure')); ?></p>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                    
                    <h4 class="mb-5 mt-5"><?php echo e(__('Pay With')); ?> <?php echo e(setting('site.site_name')); ?></h4>


                        <div class="card bg-light">
                            <div class="body">
                                <?php if(session()->get('PurchaseRequest')->attempts > 1 and  session()->get('PurchaseRequest')->attempts <= 5 ): ?>
                                    <div class="clearfix"></div>
                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>
                                            <a class="btn btn-link text-dark" href="<?php echo e(route('password.request')); ?>">
                                                <?php echo e(__('Forgot Your Password?')); ?>

                                            </a>
                                        </strong>
                                        <?php echo e(5 - session()->get('PurchaseRequest')->attempts); ?> Attempts left
                                    </div>
                                <?php endif; ?>
                                <?php echo $__env->make('flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <form class="form-horizontal" method="POST" action="<?php echo e(route('logandpay')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="ref" value="<?php echo e($ref); ?>">
                                    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                        

                                            <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="E-Mail Address">

                                            <?php if($errors->has('email')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                    </div>

                                    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                        

                                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                                            <?php if($errors->has('password')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                    </div>

                                    

                                    <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block btn-lg" style="font-weight: bold"> <?php echo e(__('Make Payment')); ?></button>
                                    </div>
                                </form>
                                <div class="clearfix"></div>
                                <hr style="margin-top: 20px; margin-bottom: 20px">
                                <div class="clearfix"></div>
                                <a href="<?php echo e(url('/')); ?>/register" class="btn btn-dark btn-block btn-lg" style="font-weight: bold; margin-bottom: 20px"><?php echo e(__('Create An Account')); ?></a>
                            </div>
                        </div>
                <?php if(
                    setting('payment-gateways.enable_paypal') == 're' 
                    or
                    setting('payment-gateways.enable_paystack') == 're'
                    or
                    setting('payment-gateways.enable_stripe') == 're'
                ): ?>
                    <h4 class="mb-5 mt-5"><?php echo e(__('Pay With Tird Part')); ?> </h4>

                        <div class="card bg-light">
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table m-b-0">
                                        
                                        <tbody>
                                            <tr>
                                            <?php if(setting('payment-gateways.enable_paypal') == 1): ?>
                                                <td style="border: 0" class="align-center">
                                                    <form method="post" action="<?php echo e(url('/')); ?>/merchant/storefront/paypal/<?php echo e($ref); ?>" id="paypal-form">
                                                        <input type="hidden" name="ref" value="<?php echo e($ref); ?>">   
                                                        <?php echo csrf_field(); ?>
                                                        <a href="" onclick="event.preventDefault();
                                             document.getElementById('paypal-form').submit();">
                                                            <img style="width: 60px; border: 0" src="<?php echo e(url('/')); ?>/storage/imgs/N7EVK0hQpVT3p0PrB95QIufkOOOmKXQ2WqiO2sPi.png" alt="" class="rounded">
                                                        </a>
                                                    </form>
                                                </td>
                                            <?php endif; ?>
                                            <?php if(setting('payment-gateways.enable_paystack') == 1): ?>
                                                <td style="border: 0"  class="align-center">
                                                    <form method="post" action="<?php echo e(url('/')); ?>/merchant/storefront/paystack/<?php echo e($ref); ?>" id="paystack-form">
                                                        <input type="hidden" name="ref" value="<?php echo e($ref); ?>">   
                                                        <?php echo csrf_field(); ?>
                                                        <a href="" onclick="event.preventDefault();
                                             document.getElementById('paystack-form').submit();">
                                                            <img style="width: 60px;border:0" src="<?php echo e(url('/')); ?>/storage/imgs/smOMNQbvaoIgP8Y2TcA6DfgAdVdWsXe1Caww3aYV.png" alt="" class="rounded">
                                                        </a>
                                                    </form>
                                                </td>
                                            <?php endif; ?>
                                            <?php if(setting('payment-gateways.enable_stripe') == 1): ?>
                                                <td style="border: 0"  class="align-center">
                                                    <img style="width: 60px;border:0" src="<?php echo e(url('/')); ?>/storage/imgs/xNyqTMuGhvfDAQGIpWxfWrz9K49MEpYlvWJgLPeG.jpeg" alt="" class="rounded">
                                                </td>
                                            <?php endif; ?>   
                                            </tr>
                                            <tr>
                                            <?php if(setting('payment-gateways.enable_paypal') == 1): ?>
                                                <td style="border:0"  class="align-center">PayPal</td>
                                            <?php endif; ?>
                                            <?php if(setting('payment-gateways.enable_paystack') == 1): ?>
                                                <td style="border:0"  class="align-center">Paystack</td>
                                            <?php endif; ?>
                                            <?php if(setting('payment-gateways.enable_stripe') == 1): ?>
                                                <td style="border:0"  class="align-center">Stripe</td>
                                            <?php endif; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                <?php endif; ?>  
                </div>
            </div>
            
        </div>
    </div>
</div>