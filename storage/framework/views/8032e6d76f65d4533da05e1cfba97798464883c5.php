<ion-fab vertical="bottom" horizontal="end" slot="fixed" mode="ios">
	<ion-fab-button  color="primary">
	  <ion-icon name="add" ></ion-icon>
	</ion-fab-button>
	<ion-fab-list side="top">
	  	<ion-fab-button  <?php if(Route::is('home')): ?> color="dark" <?php else: ?> href="<?php echo e(route('home')); ?>" <?php endif; ?> ><ion-icon name="paper" mode="ios"></ion-icon></ion-fab-button>
	   	<ion-fab-button <?php if(Route::is('sendMoneyForm')): ?> color="dark"   <?php else: ?> href="<?php echo e(route('sendMoneyForm')); ?>" <?php endif; ?>><ion-icon name="paper-plane" mode="ios"></ion-icon></ion-fab-button>
	    <ion-fab-button <?php if(Route::is('exchange.form')): ?> color="repeat" <?php else: ?> href="<?php echo e(url('/')); ?>/exchange/first/0/second/0" <?php endif; ?>><ion-icon name="repeat"></ion-icon></ion-fab-button>
	    <ion-fab-button  <?php if(Route::is('profile.info')): ?> color="dark" <?php else: ?> href="<?php echo e(route('profile.info')); ?>" <?php endif; ?>><ion-icon name="at" mode="ios"></ion-icon></ion-fab-button>
	</ion-fab-list>
</ion-fab>