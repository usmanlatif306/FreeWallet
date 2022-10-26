

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
                        <h2><strong><?php echo e(__('Start investing')); ?></strong></h2>
                    </div>
                    <div class="body block-header">
                        <div class="row">
                            <div class="col">
                               <ul id="glbreadcrumbs-two">
                                    <li><a href="#" class="a"><strong>1.</strong> <?php echo e(__('Join a plan')); ?>.</a></li>     
                                    <li><a href="#" ><strong>2.</strong> <?php echo e(__('Set your investment capital')); ?>.</a></li>
                                    <li><a href="#" class="a"><strong>3.</strong> <?php echo e(__('Invest')); ?>.</a></li>
                                </ul>
                            </div>            
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

<form method="post" action="<?php echo e(url(app()->getLocale().'/')); ?>/investment/store">
	<?php echo e(csrf_field()); ?>

    <div class="row clearfix">
    	<div class="col">	
			<div class="card">
		        <div class="header">
		            <h2><?php echo e($plan->TransferMethod->currency->name); ?> <?php echo e(__('capital')); ?> </h2>
		        </div>
		        <div class="body block-header">
		            <div class="row">
			                <div class="col">
			                	<div class="col-lg-12 ">
	                            	<label for="capital">Amount</label>
		                            <div class="" role="alert" style="color: #383d41">
		                                <div class="form-group ">
		                                  <input type="text" class="form-control" id="capital" name="capital" required="">
		                                </div>
		                            </div>
		                            <div class="row">
		                                <div class="col">
		                                    <input type="submit" class="btn btn-primary bg-blue btn-round float-right" value="<?php echo e(__('Invest Capital')); ?>">
		                                </div>
		                            </div>
	                        	</div>
			                </div>
			                <input type="hidden" name="plan_id" value="<?php echo e($plan->id); ?>">          
		            </div>
		        </div>
		    </div>
	    </div>	
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>