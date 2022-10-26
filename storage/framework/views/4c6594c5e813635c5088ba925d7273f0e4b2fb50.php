
<?php if($transactions_to_confirm->currentPage() <= $transactions_to_confirm->lastPage() and $transactions_to_confirm->total() > 0 ): ?>

  <div class="panel panel-default">
      <div class="panel-heading" style="border-bottom: 0; ">
        <div class="container">
          <div class="card bg-info">
            <div class="header">
              <h2><i class="zmdi zmdi-alert-circle-o text-white"></i> <strong class="text-white"><?php echo e(__('One more step...')); ?></strong></h2>
                <ul class="header-dropdown">  
                    <li class="remove">
                        <a role="button" class="boxs-close "><i class="zmdi zmdi-close text-white" ></i></a>
                    </li>
                </ul>
            </div>
            <div class="body block-header">
                <div class="row">
                    <div class="col">
                        <p class="text-white">   <?php echo e(__('please confirm your last transaction !')); ?> </p>
                    </div>   
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="panel-body">
        <div class="card user-account">
          <div class="header">
              <h2><strong>Pending</strong>Transactions</h2>
              
              <ul class="header-dropdown">
                  
                  <li class="remove">
                      <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                  </li>
              </ul>
              
          </div>
          <div class="body">
              <div class="table-responsive">
                  <table class="table m-b-0">
                      <thead>
                          <tr>
                               <th>id</th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('time to expire')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Gross')); ?></th>
                                <th><?php echo e(__('Fee')); ?></th>
                                <th><?php echo e(__('Net')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $transactions_to_confirm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <tr>
                            <td><?php echo e($transaction->id); ?></td>
                            <td><?php echo e($transaction->created_at->format('d M Y')); ?> <br> <?php echo $__env->make('home.partials.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></td>
                            <td>
                              <?php if($transaction->transactionable_type == 'App\Models\Send'): ?>
                              <?php echo e(__('Funds')); ?> <br><?php echo e(__('Availability')); ?>

                              <?php elseif($transaction->transactionable_type == 'App\Models\Purchase'): ?>
                              5 Min
                              <?php endif; ?>
                            </td>
                            <td><?php echo e($transaction->activity_title); ?> <?php echo $__env->make('home.partials.name', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></a></td>
                            <td><?php echo e($transaction->gross()); ?></td>
                            <td><?php echo e($transaction->fee()); ?></td>
                            <td><?php echo e($transaction->net()); ?></td>

                            <td>
                              <?php if($transaction->transactionable_type == 'App\Models\Send'): ?>
                              <form action="<?php echo e(route('sendMoneyConfirm')); ?>" method="post">
                              <?php elseif($transaction->transactionable_type == 'App\Models\Purchase'): ?>
                              <form action="<?php echo e(route('purchaseConfirm')); ?>" method="post">
                              <?php endif; ?>
                              
                              <?php echo e(csrf_field()); ?>

                              <input type="hidden" name="tid" value="<?php echo e($transaction->id); ?>">
                              <input type="submit"  class="btn btn-success btn-simple btn-round btn-xs pull-left" value="confirm">
                              </form>
                              <div class="clearfix"></div>
                            </td>
                            <td>

                              <form action="<?php echo e(url('/')); ?>/transaction/remove" method="post">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="tid" value="<?php echo e($transaction->id); ?>">
                                <input type="submit"  class="btn btn-link btn-xs pull-right" value="X">
                              </form>
                            </td>
                          </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?> 
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
      </div>
      <?php if($transactions_to_confirm->LastPage() != 1): ?>
        <div class="panel-footer">
            <?php echo e($transactions->links()); ?>

        </div>
      <?php else: ?>
      <?php endif; ?>
  </div>
<?php endif; ?>