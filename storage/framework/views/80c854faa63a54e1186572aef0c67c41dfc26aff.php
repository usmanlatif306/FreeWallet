

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
                                    <li><a href="#" ><strong>1.</strong> Select your wallet currency.</a></li>     
                                    <li><a href="#" class="a"><strong>2.</strong> <?php echo e(__('Add a money transfer method to your wallet')); ?>.</a></li>
                                    <li><a href="#" class="a"><strong>3.</strong> <?php echo e(__('Finish your wallet creation')); ?>.</a></li>
                                </ul>
                            </div>            
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row clearfix">
	<?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-lg-2 col-md-6 col-sm-12">
        <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/transfer/<?php echo e($currency->id); ?>/methods">
            
        <div class="card">
            <div class="body text-center">
                <div class="chart easy-pie-chart-1" data-percent="67" style="margin-bottom:0px"> 
                    <span>
                        <img src="<?php echo e($currency->thumb); ?>" alt="user" class="rounded-circle">
                    </span> 
                    <canvas height="100" width="100"></canvas>
                </div>
                 <h6 style="margin-top: 10px"><?php echo e($currency->name); ?></h6>
                
            </div>
        </div>
        </a>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>