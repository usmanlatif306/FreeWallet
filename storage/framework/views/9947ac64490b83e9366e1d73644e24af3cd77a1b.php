<ion-menu side="end" type="push">
  <ion-header>
    <ion-toolbar color="white">
    
    </ion-toolbar>
  </ion-header>
  <ion-content>
    <ion-list>
    
    <ion-item lines="none" float-left><ion-badge color="light"><?php echo e(Auth::user()->currentCurrency()->symbol); ?></ion-badge> <ion-button size="small" color="primary" mode="ios"><?php echo e(Auth::user()->currentCurrency()->name); ?></ion-button> </ion-item>
    <?php if(count(\App\Models\Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get())): ?>
		<?php $__currentLoopData = \App\Models\Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<ion-item lines="none" float-right><ion-text><ion-button size="small" color="light" mode="ios" href="<?php echo e(url('/')); ?>/wallet/<?php echo e($currency->id); ?>" float-right><?php echo e($currency->name); ?></ion-button></ion-text></ion-item>

       	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    </ion-list>
  </ion-content>
</ion-menu>