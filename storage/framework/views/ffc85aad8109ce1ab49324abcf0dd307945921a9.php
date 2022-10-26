

<?php $__env->startSection('content'); ?>

    <div class="row">
        <?php echo $__env->make('partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-9 ">
        	
			
			<div class="card">
			    <div class="header">
			        <h2><strong><?php echo e(__('Load')); ?></strong> <?php echo e(__('Voucher')); ?></h2>
			        <ul class="header-dropdown">
			            <li class="remove">
			                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
			            </li>
			        </ul>
			    </div>
			    <div class="body">
		           <form action="<?php echo e(route('load_my_voucher', app()->getLocale())); ?>" method="POST" id="voucher_form">
            			<?php echo e(csrf_field()); ?>

	                	<div class="row">
                			<div class="col">
                				<div class="form-group <?php echo e($errors->has('balance_amount') ? ' has-error' : ''); ?>">
			                        <label for="voucher_code"><?php echo e(__('Voucher code')); ?></label>
			                       	<input type="text"  name="voucher_code" class="form-control"  required> 
			                          <?php if($errors->has('voucher_code')): ?>
			                              <span class="help-block">
			                                  <strong><?php echo e($errors->first('voucher_code')); ?></strong>
			                              </span>
			                          <?php endif; ?>
			                    </div>
                			</div>
                			<div class="col">
                				<div class="form-group <?php echo e($errors->has('submit') ? ' has-error' : ''); ?>"><label for="balance_amount"><?php echo e(__('Load Voucher')); ?></label>
                					<input type="submit" value="<?php echo e(__('Load Voucher')); ?>" class="btn btn-block btn-primary">
                				</div>
                			</div>
	                	</div>
            		</form>   
			    </div>
			</div>
			<div class="card">
			    <div class="header">
			        <h2><strong><?php echo e(__('Generated')); ?></strong> <?php echo e(__('Vouchers')); ?></h2>
			        <ul class="header-dropdown">
			            <li class="remove">
			                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
			            </li>
			        </ul>
			    </div>
			    <div class="body">
			        <?php if($vouchers->isEmpty()): ?>
                    <div class="card">
                    	<div class="card-body">
                        <p><?php echo e(__('There are currently no vouchers.')); ?></p>
                        </div>
                    </div>
                    <?php else: ?>
                    	<?php echo e($vouchers->links()); ?>

                    		<div class="table-responsive">
		                        <table class="table">
		                            <thead>
		                                <tr>
		                                    <th class="border-top-0"><?php echo e(__('Id')); ?></th>
		                                    <th class="border-top-0"><?php echo e(__('Creared at')); ?></th>
		                                    <th class="border-top-0"><?php echo e(__('Was Loaded ?')); ?></th>
		                                    <th class="border-top-0"><?php echo e(__('Created by')); ?></th>
		                                    <th class="border-top-0"><?php echo e(__('Loaded by')); ?></th>
		                                    <th class="border-top-0"><?php echo e(__('Voucher code')); ?></th>
		                                    <th class="border-top-0"><?php echo e(__('Voucher value')); ?></th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                            	<?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                            	<tr>
		                            		<td><?php echo e($voucher->id); ?></td>
		                            		<td><?php echo e($voucher->created_at->diffForHumans()); ?></td>
		                            		<td><?php echo e($voucher->wasLoaded()); ?></td>
		                            		<td><?php echo e($voucher->User->name); ?></td>
		                            		<td><?php echo e($voucher->LoaderName()); ?></td>
		                            		<td><?php echo e($voucher->voucher_code); ?></td>
		                            		<td><?php echo e($voucher->value()); ?></td>
		                            	</tr>
		                            	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                            </tbody>
		                        </table>
		                    </div>
						<?php echo e($vouchers->links()); ?>

                    <?php endif; ?>   
			    </div>
			</div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<?php echo $__env->make('vouchers.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<script>
    	$( "#voucher_currency" )
		  .change(function () {
		    $( "#voucher_currency option:selected" ).each(function() {
		      window.location.replace("<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/wallet/"+$(this).val());
		  });
		})
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>