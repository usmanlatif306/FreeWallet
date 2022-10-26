
<?php if($transactions_to_confirm->currentPage() <= $transactions_to_confirm->lastPage() and $transactions_to_confirm->total() > 0 ): ?>
  <ion-item-divider>
    <ion-label>
      <?php echo e(__('Transactions to confirm')); ?>

    </ion-label>
  </ion-item-divider>
  <?php $__empty_1 = true; $__currentLoopData = $transactions_to_confirm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <ion-item style="border-bottom: 0 !important;">
      <?php if($transaction->money_flow != "-"): ?> <ion-icon name="trending-up" color="primary" style="no-margin" slot="start"></ion-icon> <?php else: ?> <ion-icon name="trending-down"  style="no-margin" slot="start"></ion-icon> <?php endif; ?> 
        
        <ion-label>
            <div><h4><strong><?php echo $__env->make('home.partials.name', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></strong></h4><ion-text float-right <?php if($transaction->money_flow != "-"): ?> color="primary" <?php endif; ?>> <?php echo e($transaction->gross()); ?></ion-text></div>
            <div></div>
            <div><h6><span><?php echo e($transaction->created_at->format('d M Y')); ?></span></h6></div>
       </ion-label>
    </ion-item>
      <ion-grid style="border-bottom: 1px solid #ddd;" >
       <ion-row padding>
         <ion-col>
           <?php if($transaction->transactionable_type == 'App\Models\Send'): ?>
            <form action="<?php echo e(route('sendMoneyConfirm')); ?>" method="post">
            <?php elseif($transaction->transactionable_type == 'App\Models\Purchase'): ?>
            <form action="<?php echo e(route('purchaseConfirm')); ?>" method="post">
            <?php endif; ?>
            
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="tid" value="<?php echo e($transaction->id); ?>">
            
           <ion-button color="light" expand="full" mode="ios" size="small" type="submit"><ion-icon slot="start" color="success" name="checkmark"></ion-icon><?php echo e(__('confirm')); ?></ion-button>
            </form>
         </ion-col>
         <ion-col>
           <?php if($transaction->transactionable_type == 'App\Models\Send'): ?>
          <form action="<?php echo e(route('sendMoneyDelete')); ?>" method="post">
          <?php elseif($transaction->transactionable_type == 'App\Models\Purchase'): ?>
          <form action="<?php echo e(route('purchaseDelete')); ?>" method="post">

          <?php endif; ?>

          <?php echo e(csrf_field()); ?>

          <input type="hidden" name="tid" value="<?php echo e($transaction->id); ?>">
          <ion-button color="light" expand="full" mode="ios" size="small" type="submit"><ion-icon name="close" color="danger" slot="start"></ion-icon><?php echo e(__('Undo Transaction')); ?></ion-button>
          </form>
         </ion-col>
       </ion-row>
      </ion-grid>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
  <?php endif; ?>
  
<?php endif; ?>