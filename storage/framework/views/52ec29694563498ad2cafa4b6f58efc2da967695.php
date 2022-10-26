

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('profile.partials.sidenav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		
		<div class="col-lg-9 ">
      <div class="card">
          <div class="header">
              <h2><strong><?php echo e(__('Change Password')); ?></strong></h2>
              
          </div>
          <div class="body">
             <form class="needs-validation" enctype="multipart/form-data" method="POST" action="<?php echo e(route('profile.newpassword.store')); ?>">
            <?php echo e(csrf_field()); ?>

            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="newpassword"><?php echo e(__('New password')); ?></label>
                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="" value="" required="">
                <?php if($errors->has('newpassword')): ?>
                    <div class="invalid-feedback">
                        <strong><?php echo e($errors->first('newpassword')); ?></strong>
                    </div>
                <?php endif; ?>
              </div>
              <div class="col-md-6 mb-3">
                <label for="newpasswordagain"><?php echo e(__('Repeat your new password')); ?></label>
                <input type="password" class="form-control" id="newpasswordagain" name="newpasswordagain" placeholder="" value="" required="">
                <?php if($errors->has('newpasswordagain')): ?>
                    <div class="invalid-feedback">
                        <strong><?php echo e($errors->first('newpasswordagain')); ?></strong>
                    </div>
                <?php endif; ?>
              </div>
            </div>

            <div class="mb-3">
              <label for="oldpassword"><?php echo e(__('Old Password')); ?></label>
              <input type="password" class="form-control" id="oldpassword" name="oldpassword">
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit"><?php echo e(__('Save')); ?></button>
          </form>                         
              
          </div>
      </div>
          <h4 class="mb-3"></h4>

          
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>