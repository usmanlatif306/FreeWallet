

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 " >
            <div class="card">
                <div class="header">
                    <h2><strong><?php echo e(__('New Merchant')); ?></strong></h2>
                    
                </div>
                <div class="body">
                     <form action="<?php echo e(route('merchant.add')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                      <div class="col mb-3">
                                  <div class="card content-center">
                                    <div class="card-header">
                                      <label for="avatar"><?php echo e(__('Merchant Logo')); ?></label>
                                    </div>
                                    <div class="card-body">
                                      <img src="<?php echo e(Storage::url('users/default.png')); ?>" alt="" class="img-fluid">
                                    </div>
                                  </div>
                                  <label for="avatar"><?php echo e(__('Upload a profile picture')); ?></label>
                                    <input type="file" class="form-control" name="logo" id="logo" required>
                                    <?php if($errors->has('logo')): ?>
                                          <div class="invalid-feedback">
                                              <strong><?php echo e($errors->first('logo')); ?></strong>
                                          </div>
                                      <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                              <div class="form-group">
                                <label for="merchant_currency_code"><?php echo e(__('Merchant Currency')); ?></label>
                                <select class="form-control" id="merchant_currency" name="merchant_currency">
                                  <?php $__empty_1 = true; $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                      <option value="<?php echo e($currency->id); ?>" data-value="<?php echo e($currency->id); ?>" <?php if(Auth::user()->currentCurrency()->id == $currency->id): ?>  selected <?php endif; ?>><?php echo e($currency->name); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


                                  <?php endif; ?>
                                </select>[ <span class="text-primary"><?php echo e(Auth::user()->currentCurrency()->code); ?></span> ]
                                <?php if($errors->has('merchant_currency')): ?>
                                  <span class="help-block">
                                      <strong><?php echo e($errors->first('merchant_currency')); ?></strong>
                                  </span>
                              <?php endif; ?>
                              </div>
                            </div>
                        </div>
                        <div class="col">
                          <div class="form-group <?php echo e($errors->has('merchant_name') ? ' has-error' : ''); ?>">
                            <label for="merchant_name"><?php echo e(__('Name')); ?></label>
                            <input type="text" class="form-control" id="merchant_name" name="merchant_name" value="<?php echo e(old('merchant_name')); ?>" required >
                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                </span>
                            <?php endif; ?>
                          </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col">
                          <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                            <label for="merchant_site_url"><?php echo e(__('Site URL')); ?></label>
                            <input type="text" class="form-control" id="merchant_site_url" name="merchant_site_url" value="<?php echo e(old('merchant_site_url')); ?>" required>
                            <?php if($errors->has('merchant_site_url')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('merchant_site_url')); ?></strong>
                                </span>
                            <?php endif; ?>
                          </div>
                        </div>
                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col">
                          <div class="form-group <?php echo e($errors->has('merchant_success_link') ? ' has-error' : ''); ?>">
                            <label for="merchant_success_link"><?php echo e(__('Success URL')); ?></label>
                            <input type="text" class="form-control" id="merchant_success_link" name="merchant_success_link" value="<?php echo e(old('merchant_success_link')); ?>" required>
                            <?php if($errors->has('merchant_success_link')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('merchant_success_link')); ?></strong>
                                </span>
                            <?php endif; ?>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group <?php echo e($errors->has('merchant_fail_link') ? ' has-error' : ''); ?>">
                            <label for="merchant_fail_link"><?php echo e(__('Fail URL')); ?></label>
                            <input type="text" class="form-control" id="merchant_fail_link" name="merchant_fail_link" value="<?php echo e(old('merchant_fail_link')); ?>" required>
                             <?php if($errors->has('merchant_fail_link')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('merchant_fail_link')); ?></strong>
                                </span>
                            <?php endif; ?>
                          </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col">
                          <div class="form-group <?php echo e($errors->has('merchant_description') ? ' has-error' : ''); ?>">
                            <label for="merchant_description"><?php echo e(__('Merchant Description')); ?></label>
                            <textarea class="form-control" rows="5" id="merchant_description" name="merchant_description" required><?php echo e(old('merchant_description')); ?></textarea>
                             <?php if($errors->has('merchant_description')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('merchant_description')); ?></strong>
                                </span>
                            <?php endif; ?>
                          </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                      <input type="submit" class="btn btn-outline-dark btn-lg pull-right" value="Save">
                    </div>
                    <div class="clearfix"></div>
                  </form>                       
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$( "#merchant_currency" )
  .change(function () {
    $( "#merchant_currency option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/wallet/"+$(this).val());
  });
})
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>