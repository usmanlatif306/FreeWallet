

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">
          <?php echo $__env->make('partials.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <div class="card">
            <div class="header">
              <h2><strong><?php echo e(__('How to proceed with')); ?> <?php echo e($transferMethod->name); ?> <?php echo e(__('withdraws')); ?> </strong></h2>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-lg-12">
                    <div >
                        <?php echo $transferMethod->how_to_withdraw; ?>

                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
          <div class="header">
            <h2><strong><?php echo e(__('Withdrawal Request')); ?></strong></h2>
          </div>
          <div class="body">
            <form action="<?php echo e(route('post.withdrawal', app()->getLocale())); ?>" method="post" enctype="multipart/form-data" id="withdrawal_form">
              <?php echo e(csrf_field()); ?>

              <input type="hidden" name="wid" value=<?php echo e($wid); ?>>
              <input type="hidden" name="tmid" value="<?php echo e($transferMethod->id); ?>">
              <div class="row">
              
                <div class="col-lg-7 col-xs-12">
                  <div class="row">
                    <div class="col">
                      <div class="form-group <?php echo e($errors->has('amount') ? ' has-error' : ''); ?>">
                       <label for="amount"><?php echo e(__('Amount')); ?></label>
                       <input type="number" name="amount" class="form-control"  v-on:keyup="totalize" v-on:change="totalize" 
                         <?php if(Auth::user()->currentWallet()->is_crypto == 1 ): ?>
                            step="0.00000001" 
                           <?php else: ?>
                            step="0.01" 
                           <?php endif; ?>
                       >
                        <?php if($errors->has('amount')): ?>
                            <span class="help-block">
                                <strong class="text-danger"><?php echo e($errors->first('amount')); ?></strong> <span class="text-primary"><?php echo e($transferMethod->currency->symbol); ?></span> 
                            </span>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group <?php echo e($errors->has('fee') ? ' has-error' : ''); ?>">
                       <label for="fee">Net [ <small class="bg-dark text-white"> <?php echo e(__('gross')); ?> -  <?php echo e(__('Fees')); ?> &nbsp;</span></small> ]</label>
                      
                      <br>
                       <h2 style="margin-top: 0" ><span >{{total}}</span> <?php echo e($transferMethod->currency->symbol); ?></h2> 
                        <?php if($errors->has('fee')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('fee')); ?></strong>
                            </span>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
             
              <div class="row">
                <div class="col-lg-12">
                  <input type="submit" class="btn btn-primary float-right" value="<?php echo e(__('Request Withdrawal')); ?>">
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
<?php echo $__env->make('withdrawals.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>
$( "#withdrawal_method" )
  .change(function () {
    $( "#withdrawal_method option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/withdrawal/request/"+$(this).val());
  });
});

$( "#withdrawal_currency" )
  .change(function () {
    $( "#withdrawal_currency option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/wallet/"+$(this).val());
  });
})
</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>