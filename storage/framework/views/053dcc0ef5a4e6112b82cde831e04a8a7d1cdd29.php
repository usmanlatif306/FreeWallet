<!DOCTYPE html>
<html>
<head>
	<title>My Transactions</title>
	<?php $title = 'My Transactions'; ?>
	<?php echo $__env->make('_mobile.layouts.ion_head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body >
	<?php echo $__env->make('_mobile.partials.spinner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
<ion-app >
		<?php echo $__env->make('_mobile.partials.PWA.main_menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('_mobile.partials.currencies_menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<div class="ion-page" main>
			<?php echo $__env->make('_mobile.partials.PWA.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<ion-content style="padding:0">
				<?php echo $__env->make('_mobile.partials.wallet_current', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			
	    			<ion-list lines="none">
		        		<?php echo $__env->make('_mobile.home.partials.transactions_to_confirm', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    			</ion-list>
					<ion-item-divider>
						<ion-label>
							<?php echo e(__('Completed Transactions')); ?>

						</ion-label>
					</ion-item-divider>

					<ion-list  lines="none">
						<?php echo $__env->make('_mobile.home.partials.transactions', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					</ion-list>

					
					<?php echo e($transactions->links()); ?>

			</ion-content>
			<?php echo $__env->make('_mobile.partials.fab', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		</div>
</ion-app>
<ion-menu-controller></ion-menu-controller>
<?php echo $__env->make('_mobile.layouts.js.PWA.ionjs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>
