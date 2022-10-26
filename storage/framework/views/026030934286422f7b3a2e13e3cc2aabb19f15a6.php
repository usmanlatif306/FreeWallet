<?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<ion-card <?php if($transaction->money_flow != "+"): ?> color="dark" <?php endif; ?>>
  <ion-card-header>
    <?php echo $__env->make('home.partials.name', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </ion-card-header>

  <ion-card-content >
      <ion-item style="margin-left: 0;padding-left: 0" <?php if($transaction->money_flow != "+"): ?> color="dark" <?php endif; ?>>
        
     
        
        <ion-avatar slot="start">
          <img src="<?php echo e($transaction->thumb()); ?>">
        </ion-avatar>
          
          <ion-label>
              <div><ion-text float-right <?php if($transaction->money_flow != "-"): ?> color="primary" <?php endif; ?>> <?php echo e($transaction->gross()); ?></ion-text></div>
              <div></div>
              <div><h6><span></span></h6></div>
         </ion-label>

        
      
      </ion-item>
        
    
  </ion-card-content>
</ion-card>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?>
       
        