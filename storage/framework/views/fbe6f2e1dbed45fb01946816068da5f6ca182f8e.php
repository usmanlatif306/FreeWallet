<?php if($transaction->Status->id == 1): ?>
<span class="badge badge-success"><?php echo e($transaction->Status->name); ?></span>
<?php elseif($transaction->Status->id == 2): ?>
<button class="btn btn-sm btn-outline-danger"><?php echo e($transaction->Status->name); ?></button>
<?php elseif($transaction->Status->id == 3): ?>
<span class="badge badge-info"><?php echo e($transaction->Status->name); ?></span>
<?php elseif($transaction->Status->id == 4): ?>
<button class="btn btn-sm btn-outline-primary"><?php echo e($transaction->Status->name); ?></button>
<?php endif; ?>