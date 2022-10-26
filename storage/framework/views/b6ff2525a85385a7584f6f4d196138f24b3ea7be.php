<div id="top"></div>
	
	<ion-card  color="primary" style="margin-top: -40px; margin-left: 0;margin-right: 0">
		<ion-card-header>
			<ion-card-subtitle>Wallet Balance</ion-card-subtitle>
		</ion-card-header>
		<ion-item color="primary" lines="none" margin-bottom>
			<ion-label float-left >
				<ion-card-subtitle >
					<ion-button mode="ios" id="c-but" color="primary" onclick="openEnd()" style="margin-left: -12px">
						<ion-icon name="arrow-forward" mode="ios" slot="end"></ion-icon><?php echo e(Auth::user()->currentCurrency()->name); ?>

					</ion-button>
					
				</ion-card-subtitle>
				<ion-card-title><?php echo e(\App\Helpers\Money::instance()->value(Auth::user()->balance(), Auth::user()->currentCurrency()->symbol)); ?></ion-card-title>
			</ion-label>
			<ion-button expand="block" size="large" color="secondary" float-right href="<?php echo e(route('add.credit')); ?>" mode="ios" style="margin-bottom:0">
				<ion-icon name="add-circle" ></ion-icon>
			</ion-button>
		</ion-item>	
	</ion-card>
	<?php echo $__env->make('partials.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>