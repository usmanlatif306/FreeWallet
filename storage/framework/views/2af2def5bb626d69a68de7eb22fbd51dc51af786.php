
<?php if($wallet_transactions_to_confirm->currentPage() <= $wallet_transactions_to_confirm->lastPage() and $wallet_transactions_to_confirm->total() > 0 ): ?>

  <div class="panel panel-default">
      <div class="panel-body">
        <div class="card user-account">
          <div class="header">
              <h2><strong>Pending</strong> Wallet Transactions</h2>
              
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
                              <th><?php echo e(__('Name')); ?></th>
                              <th><?php echo e(__('Gross')); ?></th>
                              <th><?php echo e(__('Fee')); ?></th>
                              <th><?php echo e(__('Net')); ?></th>
                              <th><?php echo e(__('Status')); ?></th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $wallet_transactions_to_confirm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <tr>
                            <td><?php echo e($transaction->id); ?></td>
                            <td><?php echo e($transaction->created_at->format('d M Y')); ?> <br> <?php echo $__env->make('home.partials.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></td>
                            
                            <td>
                            <?php echo $__env->make('home.partials.name', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></a></td>
                            <td><?php echo e($transaction->gross()); ?></td>
                            <td><?php echo e($transaction->fee()); ?></td>
                            <td><?php echo e($transaction->net()); ?></td>

                            <td>
                              <span class="badge badge-primary">Pending</span>
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
      <?php if($wallet_transactions_to_confirm->LastPage() != 1): ?>
        <div class="panel-footer">
            <?php echo e($transactions->links()); ?>

        </div>
      <?php else: ?>
      <?php endif; ?>
  </div>
<?php endif; ?>