<?php $__env->startSection('content'); ?>

<div class="row">
    <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="col-md-9 " style="padding-right: 0" id="#addFund">
        <?php echo $__env->make('flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="card">
            <div class="header">
                <h2><strong><?php echo e(__('Identity')); ?></strong> <?php echo e(__("Verification")); ?>

                    <a href="<?php echo e(route('identity.camera',app()->getLocale())); ?>" class="ml-2">Camera Method</a>
                </h2>

            </div>
            <div class="body">
                <form action="<?php echo e(route('identity.itentify', app()->getLocale())); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <?php if(Session::has('error')): ?>
                        <div class="col-12">
                            <div class="alert alert-danger mx-1">
                                <?php echo e(Session::get('error')); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group <?php echo e($errors->has('fornt_image') ? ' has-danger' : ''); ?>">
                                <label for="fornt_image"><?php echo e(__('Document Front Image')); ?></label>
                                <input type="file" id="fornt_image" class="form-control" name="fornt_image" required />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group <?php echo e($errors->has('back_image') ? ' has-danger' : ''); ?>">
                                <label for="back_image"><?php echo e(__('Document Back Image')); ?></label>
                                <input type="file" id="back_image" class="form-control" name="back_image" required />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group <?php echo e($errors->has('user_image') ? ' has-danger' : ''); ?>">
                                <label for="user_image"><?php echo e(__('User Image')); ?></label>
                                <input type="file" id="user_image" class="form-control" name="user_image" required />
                            </div>
                        </div>

                    </div>
                    <div class="clearfix border-bottom mt-3 mb-2"></div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('Proceed')); ?></button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>