

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
                                    <li><a href="#" ><strong>1.</strong> <?php echo e(__('Join a plan')); ?>.</a></li>     
                                    <li><a href="#" class="a"><strong>2.</strong> <?php echo e(__('Set your investment capital')); ?>.</a></li>
                                    <li><a href="#" class="a"><strong>3.</strong> <?php echo e(__('Invest')); ?>.</a></li>
                                </ul>
                            </div>            
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row clearfix">
	<?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <div class="col-lg-3 cool-md-6 col-sm-12">
		    <div class="card">
		    	<div class="header">
		    		<h2><strong><?php echo e($plan->TransferMethod->currency->name); ?></strong></h2>
		    	</div>
		        <ul class="pricing body">
		            <li><big><?php echo e($plan->name); ?></big></li>
		            <li>
		            	<span ><?php echo e($plan->min_investment); ?> <?php echo e($plan->TransferMethod->currency->code); ?> </span> <?php echo e(__('MIN INVESTMENT')); ?>  
		            	
		            </li>
		            <li>
		            	 <span ><?php echo e($plan->max_investment); ?> <?php echo e($plan->TransferMethod->currency->code); ?>  </span><?php echo e(__('MAX INVESTMENT')); ?>

		            </li>
		            <li>
		                <h3><?php echo e($plan->min_profit_percentage); ?> % <?php echo e(__('ROI')); ?></h3>
		                 <span><?php echo e($plan->withdraw_interval_days); ?> <?php echo e(__('Days')); ?></span> <?php echo e(__('WITHDRAW INTERVAL')); ?>

		            </li>
		            <li><?php echo e(__('Capital Accessible After Investment Elapses')); ?></li>
		            <li><a href="<?php echo e(url(app()->getLocale().'/')); ?>/investment/plan/<?php echo e($plan->id); ?>" class="btn btn-primary btn-round btn-simple">Join Now</a></li>
		        </ul>
		    </div>
		</div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>