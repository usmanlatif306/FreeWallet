

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">
        	<div class="card">
            <div class="body">
                <row class="clearfix">
                    <?php if($_ENV['APP_DEMO']): ?>
                        <div class="alert alert-info">
                            <p><strong>Heads up!</strong> Use the above PayPal Credentials for demo testing.</p>
                            <strong>Email : </strong> pixelotetm-buyer@gmail.com<br>
                            <strong>Password :</strong> 12345678
                        </div>
                    <?php endif; ?>
                </row>
                <div class="row">
                    <div class="preview col-lg-4 col-md-12">
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active show" id="product_1">
                            	<img src="<?php echo e(url('/')); ?>/storage/imgs/N7EVK0hQpVT3p0PrB95QIufkOOOmKXQ2WqiO2sPi.png" class="img-fluid">
                            </div>
                            
                            </div>
                                       
                    </div>
                    <div class="details col-lg-8 col-md-12" id="buy_form">
                        <h3 class="product-title m-b-0"><?php echo e(__('Add funds to your wallet with your PayPal')); ?></h3>                        
                        
                        <div class="action">
                          <form class="d-flex justify-content-left" method="post" action="<?php echo e(url('/')); ?>/buyvoucher/paypal">
                          	<div class="row mb-5">
		                      <div class="col-lg-12">
		                        <div class="form-group ">
		                          	<label for="message"><?php echo e(__('Value')); ?></label>
                            		<input type="number" value="1" name="amount" aria-label="Search" class="form-control" style="width: 100px" v-on:keyup="totalize"  v-on:change="totalize" >
		                        </div>
		                      </div>
		                    	<div class="col-lg-12">
                                    <?php echo e(csrf_field()); ?>

                            	<input type="hidden" name="product_id" value="18">
                              <input class="btn btn-primary btn-round waves-effect" value="<?php echo e(__('Purchase')); ?>" type="submit">
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
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>