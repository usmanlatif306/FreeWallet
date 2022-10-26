<?php if($transactions->total() > 0): ?>
<div class="card user-account">
          <div class="header">
              <h2><strong>Complete</strong>Transactions</h2>
              
          </div>
          <div class="body">
              <div class="table-responsive">
                  <table class="table m-b-0">
                      <thead>
                          <tr>
                              <th></th>
                              <th><?php echo e(__('Id')); ?></th>
                              <th ><?php echo e(__('Date')); ?></th>
                              <th class="hidden-xs"><?php echo e(__('Name')); ?></th>
                              <th class="hidden-xs"><?php echo e(__('Gross')); ?></th>
                              <th class="hidden-xs"><?php echo e(__('Fee')); ?></th>
                              <th><?php echo e(__('Net')); ?></th>
                              <th><?php echo e(__('Balance')); ?></th>
                          </tr>
                      </thead>
                      <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                          <td><img src="<?php echo e($transaction->thumb()); ?>" alt="" class="rounded" loading="lazy"></td>
                          <td><?php echo e($transaction->id); ?>

                          <td><?php echo e($transaction->created_at->format('d M Y')); ?> <br> <?php echo $__env->make('home.partials.status', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></td>
                          <td class="hidden-xs"> <?php echo $__env->make('home.partials.name', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></td>
                          <td class="hidden-xs"><?php echo e($transaction->gross()); ?></td>
                          <td class="hidden-xs"><?php echo e($transaction->fee()); ?></td>
                          <td><?php echo e($transaction->net()); ?></td>
                          <td><?php echo e($transaction->balance()); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    
                    <?php endif; ?>
                  </table>
              </div>
          </div>
          <?php if($transactions->LastPage() != 1): ?>
        <div class="footer">
            <?php echo e($transactions->links()); ?>

        </div>
      <?php else: ?>
      <?php endif; ?>
</div>

<?php endif; ?>