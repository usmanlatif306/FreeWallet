

<?php $__env->startSection('pre_content'); ?> 
 
<div class="row">
  <div class="col">
    <div class="card">
      <div class="row">
        <div class="col">
         <h5 class="title p-4"><?php echo e($post->title); ?></h5>
         </div>
      </div>
      <div class="row">
        <div class="col">
         <img src="<?php echo e(Storage::url($post->image)); ?>">
         </div>
      </div>
      <div class="row">
       <div class="clearfix"></div>
          <div class="header">
             
              
          </div>
          <div class="body">
                                      
              <div class="col">
              <?php echo $post->body; ?>

             </div>

          </div>
         
      </div>
    </div>
  </div>
</div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>