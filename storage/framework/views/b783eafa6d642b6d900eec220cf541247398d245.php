

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">
          <?php echo $__env->make('partials.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <div class="card">
            <div class="header">
              <h2><strong><?php echo e(__('About')); ?></strong> <?php echo e($current_method->name); ?> <?php echo e(__('withdrawals')); ?></h2>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-lg-12">
                    <div >
                        <?php echo $current_method->comment; ?>

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
            <form action="<?php echo e(route('post.withdrawal')); ?>" method="post" enctype="multipart/form-data" id="withdrawal_form">
              <?php echo e(csrf_field()); ?>

              
              <div class="row">
                <div class="col-lg-4 col-xs-12" style="display:none">
                  <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                    <div class="form-group">
                      <label for="deposit_method"><?php echo e(__('Withdrawal Currency')); ?> [ <span class="text-primary"><?php echo e(Auth::user()->currentCurrency()->code); ?></span> ]</label>
                      <select class="form-control" id="withdrawal_currency" name="withdrawal_currency">
                        <option value="<?php echo e(Auth::user()->currentCurrency()->id); ?>" data-value="<?php echo e(Auth::user()->currentCurrency()->id); ?>" selected><?php echo e(Auth::user()->currentCurrency()->name); ?> </option>
                        <?php $__empty_1 = true; $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option value="<?php echo e($currency->id); ?>" data-value="<?php echo e($currency->id); ?>"><?php echo e($currency->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


                        <?php endif; ?>
                      </select>
                      <?php if($errors->has('withdrawal_currency')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('withdrawal_currency')); ?></strong>
                        </span>
                    <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5 col-xs-12">
                  <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                    <div class="form-group">
                      <label for="withdrawal_method"><?php echo e(__('Withdrawal Method')); ?></label>
                      <select class="form-control" id="withdrawal_method" name="withdrawal_method">
                        <?php $__empty_1 = true; $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option value="<?php echo e($method->id); ?>" <?php if($method->name == $current_method->name): ?> selected <?php endif; ?>><?php echo e($method->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


                        <?php endif; ?>
                      </select>
                      <?php if($errors->has('withdrawal_method')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('withdrawal_method')); ?></strong>
                        </span>
                    <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-7 col-xs-12">
                  <div class="row">
                    <div class="col">
                      <div class="form-group <?php echo e($errors->has('amount') ? ' has-error' : ''); ?>">
                       <label for="amount"><?php echo e(__('Amount')); ?></label>
                       <input type="number" name="amount" class="form-control"  v-on:keyup="totalize" v-on:change="totalize" 
                         <?php if(Auth::user()->currentCurrency()->is_crypto == 1 ): ?>
                            step="0.00000001" 
                           <?php else: ?>
                            step="0.01" 
                           <?php endif; ?>
                       >
                        <?php if($errors->has('amount')): ?>
                            <span class="help-block">
                                <strong class="text-danger"><?php echo e($errors->first('amount')); ?></strong> <span class="text-primary"><?php echo e(Auth::user()->currentCurrency()->symbol); ?></span> 
                            </span>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group <?php echo e($errors->has('fee') ? ' has-error' : ''); ?>">
                       <label for="fee">Net [ <small class="bg-dark text-white"> <?php echo e(__('gross')); ?> -  <?php echo e(__('Fees')); ?> &nbsp;</span></small> ]</label>
                      
                      <br>
                       <h2 style="margin-top: 0" ><span >{{total}}</span> <?php echo e(Auth::user()->currentCurrency()->symbol); ?></h2> 
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
                <div class="col">
                  <div class="form-group <?php echo e($errors->has('platform_id') ? ' has-error' : ''); ?>">
                   <label for="platform_id"><?php echo e($current_method->method_identifier_field__name); ?> </label>
                 <input type="text" name="platform_id" id="platform_id" class="form-control" required> 
                    <?php if($errors->has('fee')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('platform_id')); ?></strong>
                        </span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              
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
      window.location.replace("<?php echo e(url('/')); ?>/withdrawal/request/"+$(this).val());
  });
});

$( "#withdrawal_currency" )
  .change(function () {
    $( "#withdrawal_currency option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/wallet/"+$(this).val());
  });
})
</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>