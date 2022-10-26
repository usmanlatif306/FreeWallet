

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('profile.partials.sidenav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		
		<div class="col-lg-9 ">
      <div class="card">
        <div class="header">
            <h2><strong><?php echo e(__('Personal Info')); ?></strong></h2>
            
        </div>
        <div class="body">
            <form class="needs-validation" enctype="multipart/form-data" method="POST" action="<?php echo e(route('profile.info.store', app()->getLocale())); ?>">
            <?php echo e(csrf_field()); ?>

            <div class="row mb-3">
              <div class="col-md-3">
                <div class="card">
                  <div class="card-header">
                    <label for="avatar"><?php echo e(__('Profile picture')); ?></label>
                  </div>
                  <div class="card-body">
                    <img src="<?php echo e(Auth::user()->avatar()); ?>" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12 mb-3">
                <label for="avatar"><?php echo e(__('Upload a profile picture')); ?></label>
                  <input type="file" class="form-control" name="avatar" id="avatar" >
                  <?php if($errors->has('avatar')): ?>
                        <div class="invalid-feedback">
                            <strong><?php echo e($errors->first('avatar')); ?></strong>
                        </div>
                    <?php endif; ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName"><?php echo e(__('First name')); ?></label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" value="<?php echo e(Auth::user()->first_name); ?>" required="">
                <?php if($errors->has('first_name')): ?>
                    <div class="invalid-feedback">
                        <strong><?php echo e($errors->first('first_name')); ?></strong>
                    </div>
                <?php endif; ?>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName"><?php echo e(__('Last name')); ?></label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" value="<?php echo e(Auth::user()->last_name); ?>" required="">
                <?php if($errors->has('last_name')): ?>
                    <div class="invalid-feedback">
                        <strong><?php echo e($errors->first('last_name')); ?></strong>
                    </div>
                <?php endif; ?>
              </div>
            </div>

            <div class="mb-3">
              <label for="username"><?php echo e(__('Username')); ?></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" id="username" placeholder="Username" value="<?php echo e(Auth::User()->name); ?>" disabled="">
                <div class="invalid-feedback" style="width: 100%;">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email"><?php echo e(__('Email')); ?></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com" value="<?php echo e(Auth::User()->email); ?>" disabled="">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

         

          
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit"><?php echo e(__('Save')); ?></button>
          </form>                        
            
        </div>
    </div>

          
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>