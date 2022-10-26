<?php if($deposit->Status->id == 1): ?>
<span class="badge badge-success"><?php echo e($deposit->Status->name); ?></span>
<?php elseif($deposit->Status->id == 2): ?>
<button class="btn btn-sm btn-outline-danger"><?php echo e($deposit->Status->name); ?></button>
<?php elseif($deposit->Status->id == 3): ?>
<span class="badge badge-info"><?php echo e($deposit->Status->name); ?></span>
<?php elseif($deposit->Status->id == 4): ?>
<button class="btn btn-sm btn-outline-primary"><?php echo e($deposit->Status->name); ?></button>
<?php endif; ?>