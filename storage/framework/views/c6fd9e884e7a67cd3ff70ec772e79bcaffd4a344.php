

<?php $__env->startSection('pre_content'); ?> 

    <div class="row clearfix">
      <div class="col">
        <div class="tab-content">
          <div class="tab-pane card active">
            <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="body">
              <h5 class="title"><a target="_blank" href="<?php echo e(url('/')); ?>/<?php echo e($post->slug); ?>/<?php echo e($post->id); ?>" class="text-dark"><?php echo e($post->title); ?></a></h5>
              <small><?php echo e(url('/')); ?>/<?php echo e($post->slug); ?>/<?php echo e($post->id); ?></small>
              <p class="m-t-10"><?php echo e($post->excerpt); ?></p>
              <a class="m-r-20" target="_blank" href="<?php echo e(url('/')); ?>/<?php echo e($post->slug); ?>/<?php echo e($post->id); ?>"><?php echo e(__('Read more')); ?></a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <?php endif; ?>
          <ul class="body pagination  pagination-primary"></ul>
            
          </div>
        </div>
      </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>