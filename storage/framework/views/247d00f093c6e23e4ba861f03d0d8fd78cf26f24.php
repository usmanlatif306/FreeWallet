

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">
          <div class="card">
            <div class="header">
                <h2><strong><?php echo e(__('My Merchants')); ?></strong></h2>
               
            </div>
            <div class="body">
              <div class="row">
                <div class="col">
                  <a href="<?php echo e(route('merchant.new' , app()->getLocale())); ?>" class="btn btn-primary float-right mb-4"><?php echo e(__('Add Merchant')); ?></a>
                </div>
              </div>
              <div class="clearfix"></div>                          
              <?php if( $merchants->total() > 0 ): ?>
              <div class="table-responsive">
                <table class="table table-striped" style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo e(__('Id')); ?></th>
                      <th><?php echo e(__('Logo')); ?></th>
                      <th><?php echo e(__('Cur Code')); ?></th>
                      <th><?php echo e(__('Name')); ?></th>
                      <th class="hidden-xs"><?php echo e(__('Site Url')); ?></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $merchants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $merchant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td scope="row"><?php echo e($loop->iteration); ?></td>
                          <td scope="row"><?php echo e($merchant->id); ?></td>
                          <td ><img style="width: 45px; " src="<?php echo e($merchant->logo); ?>" alt="" class="rounded" loading="lazy"></td>
                          <td><?php echo e($merchant->currency->code); ?></td>
                          <td><?php echo e($merchant->name); ?></td>
                          <td class="hidden-xs"><a href="<?php echo e($merchant->site_url); ?>" target="blank"><?php echo e($merchant->site_url); ?></a></td>
                          <td><a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/merchant/<?php echo e($merchant->id); ?>/docs" class="btn btn-primary btn-sm"><?php echo e(__('Integration Guide')); ?></a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
              </div>
              <?php endif; ?>
            </div>
          <?php if( $merchants->LastPage() > 1 ): ?>
            <div class="footer">
                  <?php echo e($merchants->links()); ?>

            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>