

<?php $__env->startSection('styles'); ?>
    <?php echo $__env->make('wallet.styles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="row clearfix">
		
		<div class="col-md-12 " >
        	<?php echo $__env->make('partials.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    	</div>

    </div>
	<div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                     <div class="header">
                        <h2><strong><?php echo e(__('Create a wallet')); ?></strong></h2>
                    </div>
                    <div class="body block-header">
                        <div class="row">
                            <div class="col">
                               <ul id="glbreadcrumbs-two">
                                    <li><a href="#"  class="a"><strong>1.</strong> <?php echo e(__('Select your wallet currency')); ?>.</a></li>     
                                    <li><a href="#" class="a"><strong>2.</strong> Add a money transfer method to your wallet.</a></li>
                                    <li><a href="#"><strong>3.</strong> Finish your wallet creation.</a></li>
                                </ul>
                            </div>            
                          
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="row clearfix">
		<div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/wallet/create/<?php echo e($method->id); ?>">
                <div class="card product_item">
                    <div class="body text-center">
                        <div class="cp_img">
                            <img src="<?php echo e($method->thumbnail); ?>" alt="Product" class="img-fluid">
                       
                        </div>
                        <h6 style="margin-top: 10px"><?php echo e($method->name); ?></h6>
                     
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-9 ">

            <div class="card bg-white">
                <div class="header">
                    <h2><strong><?php echo e(__('Register your')); ?></strong> <?php echo e($method->accont_identifier_mechanism); ?></h2>
                    
                </div>
                <form method="post" action="<?php echo e(Route('create.wallet', app()->getLocale())); ?>">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="transfer_method_id" value="<?php echo e($method->id); ?>">
                <div class="body" style="padding-top: 0;">
                  <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-lg-12 ">
                            <label for=""></label>
                            <div class="" role="alert" style="color: #383d41">
                                <div class="form-group ">
                                  <input type="text" class="form-control" id="accont_identifier_mechanism_id" name="accont_identifier_mechanism_id"  required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="submit" class="btn btn-primary float-right" value="<?php echo e(__('Register')); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>