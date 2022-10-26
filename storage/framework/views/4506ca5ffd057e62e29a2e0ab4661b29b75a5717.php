<?php $__env->startSection('content'); ?>

<div class="row">
  <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
    <?php echo $__env->make('flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="card">
      <div class="header">
        <h2><strong><?php echo e(__('Money')); ?></strong> <?php echo e(__("Transfer")); ?></h2>

      </div>
      <div class="body">
        <?php if(!auth()->user()->identified): ?>
        <div class="col-12 mb-3">
          <div class="alert alert-danger">
            Your identify is not verified yet. Kindly verified your identity to perform action. To verify
            your identity <a href="<?php echo e(route('identity.index', app()->getLocale())); ?>">click here</a>.
          </div>
        </div>
        <?php endif; ?>
        <form action="<?php echo e(route('sendMoney', app()->getLocale())); ?>" method="post" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                <div class="form-group">
                  <label for="deposit_method"><?php echo e(__('Currency')); ?> [ <span class="text-primary"><?php echo e(Auth::user()->currentCurrency()->code); ?></span> ]</label>
                  <select class="form-control" id="currency" name="currency">
                    <option value="<?php echo e(Auth::user()->currentCurrency()->id); ?>" data-value="<?php echo e(Auth::user()->currentCurrency()->id); ?>" selected><?php echo e(Auth::user()->currentCurrency()->name); ?> </option>
                    
                  </select>
                  <?php if($errors->has('currency')): ?>
                  <span class="help-block">
                    <strong><?php echo e($errors->first('currency')); ?></strong>
                  </span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="form-group <?php echo e($errors->has('amount') ? ' has-danger' : ''); ?>">
                <label for="amount"><?php echo e(__('Amount')); ?></label>
                <input type="number" class="form-control" id="amount" name="amount" value="<?php echo e(old('amount')); ?>" required placeholder="5.00" pattern="[0-9]+([\.,][0-9]+)?" <?php if(Auth::user()->currentCurrency()->is_crypto == 1 ): ?>
                step="0.00000001"
                <?php else: ?>
                step="0.01"
                <?php endif; ?>
                >
                <?php if($errors->has('amount')): ?>
                <div class="form-control-feedback">
                  <strong><?php echo e($errors->first('amount')); ?></strong>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <label for="email"><?php echo e(__('User email')); ?></label>
              <div class="input-group <?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <input type="text" class="form-control email" id="email" name="email" placeholder="Ex: example@example.com" required>
                <?php if($errors->has('email')): ?>
                <div class="form-control-feedback">
                  <strong><?php echo e($errors->first('email')); ?></strong>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col">
              <div class="form-group <?php echo e($errors->has('description') ? ' has-danger' : ''); ?>">
                <label for="description"><?php echo e(__('Note for Recepient')); ?></label>
                <textarea class="form-control" rows="5" id="description" name="description" placeholder="<?php echo e(__('Write a note...')); ?>" required></textarea>
                <?php if($errors->has('description')): ?>
                <div class="form-control-feedback">
                  <strong><?php echo e($errors->first('description')); ?></strong>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="form-group<?php echo e($errors->has('verify-code') ? ' has-error' : ''); ?>">
            <label for="secret" class="control-label">Authenticator Code</label>
            <input id="secret" type="text" class="form-control" name="secret" required>
            <?php if($errors->has('verify-code')): ?>
            <span class="help-block">
              <strong><?php echo e($errors->first('verify-code')); ?></strong>
            </span>
            <?php endif; ?>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col">
              <input type="submit" class="btn btn-primary float-right" value="<?php echo e(__('Send Money')); ?>" <?php echo e(auth()->user()->identified ? '' : 'disabled'); ?>>
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
  $("#currency")
    .change(function() {
      $("#currency option:selected").each(function() {
        window.location.replace("<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/wallet/" + $(this).val());
      });
    })
</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>