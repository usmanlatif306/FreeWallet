

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		
		<div class="col-md-9 ">
        
	        <?php if($deposits->total()>0): ?>
          <div class="card">
            <div class="header">
                <h2><strong><?php echo e(__('My Deposits')); ?></strong></h2>
                
            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-striped"  style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th><?php echo e(__('Date')); ?></th>
                      <th><?php echo e(__('Method')); ?></th>
                      <th><?php echo e(__('Gross')); ?></th>
                      <th><?php echo e(__('Fee')); ?></th>
                      <th><?php echo e(__('Net')); ?></th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                      <tr>
                        <td><?php echo e($deposit->created_at->format('d M Y')); ?> <br> <?php echo $__env->make('deposits.partials.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></td>
                        <td><?php echo e($deposit->Method->name); ?></td>
                        <td><?php echo e($deposit->gross()); ?></td>
                        <td><?php echo e($deposit->fee()); ?></td>
                        <td><?php echo e($deposit->net()); ?></td>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    
                    <?php endif; ?>
                  </tbody>
                </table>                          
              </div> 
            </div>
            <?php if($deposits->LastPage() != 1): ?>
              <div class="footer">
                  <?php echo e($deposits->links()); ?>

              </div>
            <?php else: ?>
            <?php endif; ?>
        </div>
          <?php endif; ?>

    	</div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>