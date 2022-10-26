

<?php $__env->startSection('content'); ?>

    <div class="row clearfix">
        
		
		<div class="col-md-12 " >
        	<?php echo $__env->make('partials.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        	
        	<?php if($users->total() > 0): ?>

        	<div class="card user-account">
				<div class="header">
				  <h2><strong>Complete</strong>Transactions</h2>
				  
				</div>
				<div class="body">
				<div class="table-responsive">
				  <table class="table m-b-0">
				      <thead>
				          <tr>
				              <th><?php echo e(__('Avatar')); ?></th>
				              <th><?php echo e(__('Id')); ?></th>
				              <th ><?php echo e(__('name')); ?></th>
				              <th class="hidden-xs"><?php echo e(__('email')); ?></th>
				              <th class="hidden-xs"><?php echo e(__('Phonenumber')); ?></th>
				              <th class="hidden-xs"><?php echo e(__('Impersonate')); ?></th>
				          </tr>
				      </thead>
				      <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
				        <tr>
				          <td><img src="<?php echo e($user->avatar()); ?>" alt="" class="rounded" loading="lazy"></td>
				          <td><?php echo e($user->id); ?></td>
				          <td><?php echo e($user->name); ?></td>
				          <td class="hidden-xs"> <?php echo e($user->email); ?></td>
				          <td class="hidden-xs"><?php echo e($user->whatsapp); ?></td>
				          <td class="hidden-xs"><a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/impersonate/user/<?php echo e($user->id); ?>">Impersonate</a></td>
				        </tr>
				    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
				    
				    <?php endif; ?>
				  </table>
				</div>
				</div>
				<?php if($users->LastPage() != 1): ?>
				<div class="footer">
					<?php echo e($users->links()); ?>

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