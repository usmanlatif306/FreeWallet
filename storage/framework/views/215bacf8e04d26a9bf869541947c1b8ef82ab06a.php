

<?php $__env->startSection('content'); ?>

  <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         <div class="col-md-9 " >
  

 <?php if($show_exchange_rates_form): ?>
            <div class="row">
              <div class="col">
                <div class="card ">
                  <div class="header">
                    <h2><strong>Set Exchange rates for</strong> <?php echo e(Auth::user()->currentCurrency()->name); ?></h2> 
                    <ul class="header-dropdown">
                      <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                  </div>
                  <div class="body">
                      <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                      <form method="post" action="<?php echo e(url('/')); ?>/update_rates">
                      <?php echo e(csrf_field()); ?>

                      <div class="form-group ">
                          <?php if(Auth::user()->currentCurrency()->code != $currency->code): ?>
                            
                              <div class="row">
                                <div class="col-lg-2">
                                  <span class="float-right">1 <strong><?php echo e(Auth::user()->currentCurrency()->code); ?></strong> =</span>
                                </div>
                                <div class="col">
                                  <input type="text" name="amount" 

                                  <?php $__currentLoopData = $update_rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($rate->secondCurrency->id == $currency->id): ?>

                                      value="<?php echo e($rate->exchanges_to_second_currency_value); ?>" 
                                    
                                    <?php endif; ?>
                                  
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                  class="form-control">
                                  
                                </div>
                                <div class="col">
                                  <label for="amount"><strong><?php echo e($currency->code); ?></strong></label>  <input type="submit" class="btn btn-primary btn-round btn-sm" style="margin-left: 20px" value="Update Exchange Rate"/>
                                </div>
                              </div>
                          <?php endif; ?>            
                      </div>

                      <input type="hidden" name="second_currency_id" value="<?php echo e($currency->id); ?>">
                      </form>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
      </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>