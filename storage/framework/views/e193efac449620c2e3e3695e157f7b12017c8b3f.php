<?php if($transaction->activity_title == 'Money Sent'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"><?php echo e(__('To')); ?> <?php echo e($transaction->entity_name); ?></a>

<?php elseif($transaction->activity_title == 'Withdrawal'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"><?php echo e(__('To')); ?> <?php echo e($transaction->entity_name); ?></a>

<?php elseif($transaction->activity_title == 'Money Received'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"><?php echo e(__('From')); ?> <?php echo e($transaction->entity_name); ?></a>
	
<?php elseif($transaction->activity_title == 'Payment Received'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"><?php echo e(__('From')); ?> <?php echo e($transaction->entity_name); ?></a>

<?php elseif($transaction->activity_title == 'Payment Received'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"><?php echo e(__('From')); ?> <?php echo e($transaction->entity_name); ?></a>

<?php elseif($transaction->activity_title == 'Voucher Load'): ?>

	<?php echo e($transaction->entity_name); ?> <br><a href="#"> <?php echo e(__('Voucher Load')); ?></a>

<?php elseif($transaction->activity_title == 'Voucher Generation'): ?>

	<?php echo e($transaction->entity_name); ?> <br><a href="#"> <?php echo e(__('Voucher Generation')); ?></a>

<?php elseif($transaction->activity_title == 'Added Voucher to system'): ?>

	<?php echo e($transaction->entity_name); ?> <br><a href="#"> <?php echo e(__('Added Voucher to system')); ?></a>

<?php elseif($transaction->activity_title == 'Purchase'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"><?php echo e(__('From')); ?> <?php echo e($transaction->entity_name); ?></a>

<?php elseif($transaction->activity_title == 'Deposit'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"><?php echo e(__('From')); ?> <?php echo e($transaction->entity_name); ?></a>

<?php elseif($transaction->activity_title == 'Sale'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"><?php echo e(__('In')); ?> <?php echo e($transaction->entity_name); ?> </a>

<?php elseif($transaction->activity_title == 'Currency Exchange'): ?>

	<?php echo e($transaction->activity_title); ?> <br><a href="#"> <?php if($transaction->money_flow == '+'): ?> <?php echo e(__('Exchanged To')); ?> 	
<?php else: ?> <?php echo e(__('Exchanged From')); ?> <?php endif; ?> <?php echo e($transaction->entity_name); ?></a>

<?php endif; ?>
