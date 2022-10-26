<?php if($transaction->Status->id == 1): ?>
<span class="badge badge-success"><?php echo e($transaction->Status->name); ?></span>
<?php elseif($transaction->Status->id == 2): ?>
<span class="badge badge-danger"><?php echo e($transaction->Status->name); ?></span>
<?php elseif($transaction->Status->id == 3): ?>
<span class="badge badge-info"><?php echo e($transaction->Status->name); ?></span>
<?php elseif($transaction->Status->id == 4): ?>
<span class="badge badge-primary"><?php echo e($transaction->Status->name); ?></span>
<?php endif; ?>