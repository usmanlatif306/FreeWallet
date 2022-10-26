

<?php $__env->startSection('content'); ?> 
 

    <div class="row">
    	<div class="col">
       <h1><?php echo e($page->title); ?></h1>
       </div>
    </div>
    <div class="row">
    	<div class="col">
       <?php echo e($page->image); ?>

       </div>
    </div>
    <div class="row">
	   <div class="clearfix"></div>
     <div class="card">
    <div class="header">
       
        
    </div>
    <div class="body">
                                
        <div class="col">
        <?php echo $page->body; ?>

       </div>

    </div>
</div>
       
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>