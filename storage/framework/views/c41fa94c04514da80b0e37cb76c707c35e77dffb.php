

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          <?php echo $__env->make('flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <div class="card">
              <div class="header">
                 <h2><strong> <?php echo e(__('Escrow ')); ?> </strong> | id: #<?php echo e($escrow->id); ?> </h2>
              </div>
              <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Holding Period')); ?></th>
                                <th><?php echo e(__('created_at')); ?></th>
                                <th><?php echo e(__('Sender Email')); ?></th>
                                <th><?php echo e(__('Receiver Email')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Gross')); ?></th>
                                <th><?php echo e(__('Fee')); ?></th>
                                <th><?php echo e(__('Net')); ?></th>
                            </tr>
                        </thead>
                          <tr>
                            <td><?php echo e(setting('escrows.hpd')); ?> <?php echo e(__('days')); ?></td>
                            <td><?php echo e($escrow->created_at->diffForHumans()); ?></td>
                            <td><?php echo e($sender->email); ?></td>
                            <td><?php echo e($receiver->email); ?></td>
                            <td><?php echo e($escrow->escrow_transaction_status); ?></td>
                            <td><?php echo e($escrow->currency_symbol); ?><?php echo e($escrow->gross); ?></td>
                            <td><?php echo e($escrow->currency_symbol); ?><?php echo e($escrow_fee); ?></td>
                            <td><?php echo e($escrow->currency_symbol); ?><?php echo e($escrow->gross - $escrow_fee); ?></td>
                            
                          </tr>
                    </table>
                </div>
              </div>
              <div class="header">
                <h2><strong> <?php echo e(__('Agreement ')); ?> </strong> | <?php echo e(__('The agreement between the Buyer and Seller')); ?> </h2>
              </div>
              <div class="body">
                <div class="row mb-5">
                  <div class="col-lg-12 ">
                      <label for=""></label>
                      <div  class="bg-white alert alert-secondary" role="alert" style="color: #383d41">
                          <?php echo e($escrow->description); ?>

                      </div>
                  </div>
                </div>
              </div>
              <?php if($escrow->escrow_transaction_status != 'completed'): ?>
              <div class="body">
                <div class="float-right">
                  <?php if(Auth::user()->role_id == 1): ?>
                    <form action="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/escrow/refund" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="eid" value="<?php echo e($escrow->id); ?>">
                        <input type="submit" class="btn  btn-round btn-danger" value="<?php echo e(_('Refund Payment')); ?>">
                    </form>
                    <form action="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/escrow/release" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="eid" value="<?php echo e($escrow->id); ?>">
                        <input type="submit" class="btn  btn-round btn-primary bg-blue" value="<?php echo e(_('Release Payment')); ?>">
                    </form>
                  <?php elseif(Auth::user()->id == $sender->id): ?>
                    <form action="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/escrow/release" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="eid" value="<?php echo e($escrow->id); ?>">
                        <input type="submit" class="btn  btn-round btn-primary bg-blue" value="<?php echo e(_('Release Payment')); ?>">
                    </form>
                  <?php elseif(Auth::user()->id == $receiver->id): ?>
                    <form action="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/escrow/refund" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="eid" value="<?php echo e($escrow->id); ?>">
                        <input type="submit" class="btn  btn-round btn-danger" value="<?php echo e(_('Refund Payment')); ?>">
                    </form>
                  <?php endif; ?>
                  </div>
                  <div class="clearfix"></div>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
$( "#currency" )
  .change(function () {
    $( "#currency option:selected" ).each(function() {
      window.location.replace("<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/wallet/"+$(this).val());
  });
})
</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>