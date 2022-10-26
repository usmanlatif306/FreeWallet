

<?php $__env->startSection('content'); ?>
<div class="container">

    <?php if($merchant): ?>
   
    <div class="row justify-content-md-center">
    <?php echo $__env->make('merchant.partials.logandpay', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.storefront', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>