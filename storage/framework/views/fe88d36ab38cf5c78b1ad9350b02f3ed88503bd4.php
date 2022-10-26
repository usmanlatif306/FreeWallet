<?php if($withdrawal->Status->id == 1): ?>
<span class="badge badge-success"><?php echo e($withdrawal->Status->name); ?></span>
<?php elseif($withdrawal->Status->id == 2): ?>
<button class="btn btn-sm btn-outline-danger"><?php echo e($withdrawal->Status->name); ?></button>
<?php elseif($withdrawal->Status->id == 3): ?>
<span class="badge badge-info"><?php echo e($withdrawal->Status->name); ?></span>
<?php elseif($withdrawal->Status->id == 4): ?>
<button class="btn btn-sm btn-outline-primary"><?php echo e($withdrawal->Status->name); ?></button>
<?php endif; ?>