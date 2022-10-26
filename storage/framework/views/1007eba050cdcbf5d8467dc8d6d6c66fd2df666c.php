

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('profile.partials.sidenav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		
		<div class="col-lg-9 ">
      <div class="card">
        <div class="header">
            <h2><strong><?php echo e(__('Proof of Identity')); ?></strong> </h2>
            
        </div>
        <div class="body">
            <form class="needs-validation" enctype="multipart/form-data" method="POST" action="<?php echo e(route('profile.identity.store')); ?>">
            <?php echo e(csrf_field()); ?>

            <div class="row mb-3">
              <div class="col-md-12 mb-3">
                <label for="avatar"><?php echo e(__('Upload a national id document issued by a legal government entity')); ?></label>
                  <input type="file" class="form-control" name="document" id="avatar" >
                  <?php if($errors->has('avatar')): ?>
                        <div class="invalid-feedback">
                            <strong><?php echo e($errors->first('avatar')); ?></strong>
                        </div>
                    <?php endif; ?>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <label for="avatar"><?php echo e(__('Document')); ?></label>
                  </div>
                  <?php if(Auth::user()->profile != null ): ?>
                  <div class="card-body">
                    <img src="<?php echo e(Auth::user()->profile->document()); ?>" alt="" class="img-fluid">
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
                  
            <hr class="mb-4">
            <input class="btn btn-primary btn-lg btn-block" type="submit" value="<?php echo e(__('Save')); ?>"></input>
          </form>                       
            
        </div>
    </div>
          
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>