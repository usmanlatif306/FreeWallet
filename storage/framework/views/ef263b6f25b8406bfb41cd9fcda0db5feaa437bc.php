


<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 " >

          <div class="card bg-light" >
            <div class="header">
                <h2><strong><?php echo e(__('How to proceed with')); ?> <?php echo e($current_method->name); ?> <?php echo e(__('deposits')); ?> </strong></h2>
                
            </div>
            <div class="body">
              <div class="clearfix"></div>
                <div class="row mb-5">
                  <div class="col-lg-12 ">
                      <label for=""></label>
                      <div  class="bg-white alert alert-secondary" role="alert" style="color: #383d41">
                          <?php echo $current_method->how_to; ?>

                      </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="card" >
            <div class="header">
                <h2><strong><?php echo e(__('Deposit Request Form')); ?></strong></h2>
                
            </div>
            <div class="body">
              <form action="<?php echo e(route('post.credit')); ?>" method="post" enctype="multipart/form-data" >
                    <?php echo e(csrf_field()); ?>

                    <div class="row mb-5">
                      <div class="col">
                        <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                            <label for="deposit_method"><?php echo e(__('Deposit Currency')); ?></label>
                            <select class="form-control" id="deposit_currency" name="deposit_currency">
                              <option value="<?php echo e(Auth::user()->currentCurrency()->id); ?>" data-value="<?php echo e(Auth::user()->currentCurrency()->id); ?>" selected><?php echo e(Auth::user()->currentCurrency()->name); ?> </option>
                              <?php $__empty_1 = true; $__currentLoopData = $current_method->currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php if($currency->id != Auth::user()->currentCurrency()->id): ?>
                                  <option value="<?php echo e($currency->id); ?>" data-value="<?php echo e($currency->id); ?>"><?php echo e($currency->name); ?></option>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


                              <?php endif; ?>
                            </select>
                            <?php if($errors->has('deposit_currency')): ?>
                              <span class="help-block">
                                  <strong><?php echo e($errors->first('deposit_currency')); ?></strong>
                              </span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      <div class="col" style="display: none;">
                        <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                          <div class="form-group">
                            <label for="deposit_method"><?php echo e(__('Deposit Method')); ?></label>
                            <select class="form-control" id="deposit_method" name="deposit_method">
                              <?php $__empty_1 = true; $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                  <option value="<?php echo e($method->id); ?>" <?php if($method->name == $current_method->name): ?> selected <?php endif; ?>><?php echo e($method->name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


                              <?php endif; ?>
                            </select>
                            <?php if($errors->has('deposit_method')): ?>
                              <span class="help-block">
                                  <strong><?php echo e($errors->first('deposit_method')); ?></strong>
                              </span>
                          <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="row mb-5">
                      <div class="col">
                        <div class="form-group <?php echo e($errors->has('message') ? ' has-error' : ''); ?>">
                          <label for="message"><?php echo e(__('Message to the reviewer')); ?> </label>
                          <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="<?php echo e(__('Message to the reviewer')); ?>" style="border: 1px solid #eeee;"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row bm-5">
                      <div class="col">
                        <div class="form-group <?php echo e($errors->has('deposit_screenshot') ? ' has-error' : ''); ?>">
                          <label for="deposit_screenshot"><?php echo e($current_method->name); ?> <?php echo e(__('Transaction Receipt Screenshot')); ?></label>
                          <input type="file" class="form-control" id="deposit_screenshot" name="deposit_screenshot" value="<?php echo e(old('merchant_logo')); ?>" required>
                          <?php if($errors->has('deposit_screenshot')): ?>
                              <span class="help-block">
                                  <strong><?php echo e($errors->first('deposit_screenshot')); ?></strong>
                              </span>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-5">
                      <div class="col mt-5 ">
                        <input type="submit" class="btn btn-primary float-right" value="<?php echo e(__('Save Deposit')); ?>">
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </form>                          
                
            </div>
        </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script>
$( "#deposit_method" )
  .change(function () {
    $( "#deposit_method option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/addcredit/"+$(this).val());
    });
  });
  $( "#deposit_currency" )
  .change(function () {
    $( "#deposit_currency option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/wallet/"+$(this).val());
    });
  })
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>