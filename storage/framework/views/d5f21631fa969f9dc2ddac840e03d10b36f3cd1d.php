

<?php $__env->startSection('content'); ?>
<?php echo e(dd($wallet)); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 " >
          <div class="row">
            <div class="col">
              <form action="<?php echo e(route('post.exchange', app()->getLocale())); ?>" method="post" id="exchange_form" enctype="multipart/form-data">
                <div class="card">
                    <div class="header">
                        <h2><strong><?php echo e(__('Exchange')); ?></strong> <?php echo e(__('money between wallets')); ?></h2>
                       
                    </div>
                    <div class="body">
                         <?php echo e(csrf_field()); ?>

                          <input type="hidden" name="exchange_id" value="<?php echo e($exchange->id); ?>">
                          <div class="row">
                            <div class="col">
                              <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                                <div class="form-group">
                                  
                                  <select class="form-control d-none" id="first_currency_id" name="first_currency_id">
                                        <option value="<?php echo e($firstCurrency->id); ?>" data-value="<?php echo e($firstCurrency->id); ?>" selected ><?php echo e($firstCurrency->name); ?></option>
                                  </select>
                                  <?php if($errors->has('first_currency_id')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('first_currency_id')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            
                          </div>
                          <div class="clearfix"></div>
                          <div class="row">
                            
                            <div class="col">
                              <div class="form-group <?php echo e($errors->has('amount') ? ' has-error' : ''); ?>">
                                 <label for="amount"><h6><?php echo e(Auth::user()->currentCurrency()->name); ?> <?php echo e(__('Amount')); ?></h6></label>
                                 <input type="text" name="amount" class="form-control" value="0"  v-on:keyup="exchange" v-on:change="exchange">
                                  <?php if($errors->has('amount')): ?>
                                      <span class="help-block">
                                          <strong><?php echo e($errors->first('amount')); ?></strong>
                                      </span>
                                  <?php endif; ?>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            
                            <div class="col">
                              <div class="form-group <?php echo e($errors->has('merchant_site_url') ? ' has-error' : ''); ?>">
                                <div class="form-group">
                                 
                                  <select class="form-control d-none" id="second_currency_id" name="second_currency_id">
                                        <option value="<?php echo e($secondCurrency->id); ?>" data-value="<?php echo e($secondCurrency->id); ?>" selected><?php echo e($secondCurrency->name); ?></option>
                                  </select>
                                  <div class="nav-item dropdown">
                                      <div id="CurrencyNavbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="" style="padding-left: 0"><label for="amount"><h6><?php echo e(__('Available')); ?> <?php echo e($secondCurrency->name); ?>  <?php echo e(__('Amount')); ?></h6></label> <span class="btn btn-primary btn-round bg-blue float-right btn-lg"><?php echo e(\App\Helpers\Money::instance()->value($wallet->amount, $wallet->Currency->symbol)); ?></span></div>
                                      <div class="dropdown-menu" aria-labelledby="CurrencyNavbarDropdown">
                                         <?php $__empty_1 = true; $__currentLoopData = $secondCurrenciesExchanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                         <?php if($currency->secondCurrency->id != $secondCurrency->id): ?>
                                        <a class="dropdown-item" href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/exchange/first/<?php echo e($firstCurrency->id); ?>/second/<?php echo e($currency->secondCurrency->id); ?>"> 
                                        <?php echo e($currency->secondCurrency->name); ?>

                                        </a>
                                        <?php endif; ?>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                      </div>
                                  </div>
                                  <?php if($errors->has('second_currency_id')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('second_currency_id')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                </div>
                              </div>
                            </div>
                            
                          </div>
                          <div class="row">
                            <div class="col">
                              <div class="form-group <?php echo e($errors->has('amount') ? ' has-error' : ''); ?>">
                                 <label for="amount"><h2 class=" mb-0 mt-0"><span>+</span> <span class="text-primary">{{total}}</span><small><?php echo e($secondCurrency->symbol); ?></small></h2></label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <input type="submit" class="btn btn-primary btn-round btn-block btn-lg pull-right" value="<?php echo e(__('Exchange')); ?>">
                            </div>
                          </div>
                          <div class="clearfix"></div>                       
                        
                    </div>
                </div>
              </form>
            </div>
          </div>
         
        </div>
    </div>

 
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php echo $__env->make('exchange.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>
$( "#first_currency_id" )
  .change(function () {
    $( "#first_currency_id option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/exchange/first/" +$(this).val()+"/second");
  });
});

$( "#second_currency_id" )
  .change(function () {
    $( "#second_currency_id option:selected" ).each(function() {
      window.location.replace(window.location.href+'/'+$(this).val());
  });
})
  //   ;

</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>