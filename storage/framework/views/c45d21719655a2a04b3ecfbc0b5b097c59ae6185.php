


<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">

          <div class="card bg-light" >
            <div class="header">
                <h2><strong><?php echo e(__('How to proceed with')); ?> <?php echo e($transferMethod->name); ?> <?php echo e(__('deposits')); ?> </strong></h2>
                
            </div>
            <div class="body">
              <div class="clearfix"></div>
                <div class="row mb-5">
                  <div class="col-lg-12 ">
                      <label for=""></label>
                      <div  class="bg-white alert alert-secondary" role="alert" style="color: #383d41">
                          <?php echo $transferMethod->how_to_deposit; ?>

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
              <form action="<?php echo e(route('post.credit', app()->getLocale())); ?>" method="post" enctype="multipart/form-data" >
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" value="<?php echo e($transferMethod->id); ?>" name="tmid">
                    <input type="hidden" value="<?php echo e($wid); ?>" name="wid">
                    <?php if($errors->has('wid')): ?>
                              <span class="help-block">
                                  <strong><?php echo e($errors->first('wid')); ?></strong>
                              </span>
                          <?php endif; ?>
                          <?php if($errors->has('tmid')): ?>
                              <span class="help-block">
                                  <strong><?php echo e($errors->first('tmid')); ?></strong>
                              </span>
                          <?php endif; ?>
                    <div class="row bm-5">
                      <div class="col">
                        <div class="form-group <?php echo e($errors->has('deposit_screenshot') ? ' has-error' : ''); ?>">
                          <label for="deposit_screenshot"><?php echo e($transferMethod->name); ?> <?php echo e(__('Transaction Receipt Screenshot')); ?></label>
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
                       <div class="col">
                        <div class="form-group <?php echo e($errors->has('unique_transaction_id') ? ' has-error' : ''); ?>">
                          <label for="unique_transaction_id"><?php echo e(__('Unique')); ?> <?php echo e($transferMethod->name); ?> <?php echo e(__('transaction id')); ?></label>
                          <input type="text" class="form-control" id="unique_transaction_id" name="unique_transaction_id" value="<?php echo e(old('merchant_logo')); ?>" required>
                          <?php if($errors->has('unique_transaction_id')): ?>
                              <span class="help-block">
                                  <strong><?php echo e($errors->first('unique_transaction_id')); ?></strong>
                              </span>
                          <?php endif; ?>
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
      window.location.replace("<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/addcredit/"+$(this).val());
    });
  });
  $( "#deposit_currency" )
  .change(function () {
    $( "#deposit_currency option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/wallet/"+$(this).val());
    });
  })
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>