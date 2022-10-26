

<?php $__env->startSection('styles'); ?>
    <?php echo $__env->make('wallet.styles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="row clearfix">
		
		<div class="col-md-12 " >
        	<?php echo $__env->make('partials.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    	</div>

    </div>

    <div class="row clearfix">
    	<div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong><?php echo e(__('Investments')); ?></strong></h2>
                </div>
                <div class="body block-header">
                    <div class="row">
                        <div class="col">
							<table class="table table-bordered table-striped table-hover js-basic-example dataTable no-footer" >
							   <thead>
							      <tr role="row">
							         <th class="sorting_desc">ID</th>
							         <th class="sorting"><?php echo e(__('Package')); ?></th>
							         <th class="sorting"><?php echo e(__('Capital')); ?></th>
							         <th class="sorting"><?php echo e(__('Date')); ?></th>
							         <th class="sorting"><?php echo e(__('Elapses')); ?></th>
							        
							         <th class="sorting"><?php echo e(__('Status')); ?></th>
							       
							         <th class="sorting"><?php echo e(__('Total Earnings')); ?></th>
							         <th class="sorting"><?php echo e(__('Action')); ?></th>
							      </tr>
							   </thead>
							   <tbody>
							   	<?php $__currentLoopData = $investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							      <tr role="row" <?php if( $loop->index % 2 == 0 ): ?> class="odd" <?php else: ?> class="even" <?php endif; ?>>
							         <td class="sorting_1"><?php echo e($investment->id); ?></td>
							         <td><?php echo e($investment->Plan->name); ?></td>
							         <td><?php echo e($investment->capital); ?></td>
							         <td><?php echo e($investment->start); ?></td>
							         <td><?php echo e($investment->end); ?></td>
							         
							         <td><?php if( $investment->status == 1 ): ?><span class="badge badge-primary"> Active </span> <?php else: ?> <span class="badge badge-default"> Complete </span> <?php endif; ?></td>
							        
							         <td><?php echo e($investment->earnings); ?></td>
							         <td>
							         	<form method="post" action="<?php echo e(url(app()->getLocale().'/')); ?>/investment/take_profit">
							         		<input type="hidden" name="inv_id" value="<?php echo e($investment->id); ?>">
							         		<?php echo e(csrf_field()); ?>

							            	<input type="submit" class="btn btn-sm btn-neutral margin-0" value="<?php echo e(__('Take Profits')); ?>">
							            </form>
							         </td>
							      </tr>
							    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							   </tbody>
							</table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>









<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>