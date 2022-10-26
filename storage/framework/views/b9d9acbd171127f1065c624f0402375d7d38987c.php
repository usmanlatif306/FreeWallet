<div class="col-md-3">
    <div class="list-group">
        <a href="<?php echo e(url('/')); ?>"  class="list-group-item list-group-item-action <?php echo e((Route::is('home') ? 'active' : '')); ?>"><?php echo e(__('Home')); ?></a>
        <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/profile/info"  class="list-group-item list-group-item-action <?php echo e((Route::is('profile.info') ? 'active' : '')); ?>"><?php echo e(__('Personal Info')); ?></a>
        <a href="<?php echo e(route('profile.identity', app()->getLocale())); ?>" class="list-group-item list-group-item-action <?php echo e((Route::is('profile.identity') ? 'active' : '')); ?>"><?php echo e(__('Proof of Identity')); ?></a>
        <a href="<?php echo e(route('profile.newpassword', app()->getLocale())); ?>" class="list-group-item list-group-item-action <?php echo e((Route::is('profile.newpassword') ? 'active' : '')); ?>"><?php echo e(__('Change Password')); ?></a>
    </div>
</div>