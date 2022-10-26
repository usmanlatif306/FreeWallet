



<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 " >
          
           <div class="card" >
            <div class="header">
                <h2><strong><?php echo e(__('Manual Deposit Methods')); ?></strong><?php if($_ENV['APP_DEMO']): ?> *Registered by admin <?php endif; ?></h2>
                
            </div>
            <div class="body">
              <?php $__empty_1 = true; $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="<?php echo e($method->thumb); ?>" alt="Generic placeholder image"  style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left"><?php echo e($method->name); ?></strong><a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/addcredit/<?php echo e($method->id); ?>" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

              <?php endif; ?>

            </div>
          </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>