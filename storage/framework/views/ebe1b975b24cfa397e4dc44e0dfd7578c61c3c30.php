<?php if($myRequests): ?>
<?php $__currentLoopData = $myRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="card">
	    <div class="header">
	        <h2><strong># <?php echo e($request->id); ?> :: Pending</strong> Money Request</h2>
	        <ul class="header-dropdown">
                <li class="remove">
                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                </li>
            </ul>
	        
	    </div>
	    <div class="body block-header">
	        <div class="row">
	            <div class="col">
	                <h2>To <?php echo e($request->from->name); ?> </h2>
	                <ul class="breadcrumb p-l-0 p-b-0 ">
	                    <li class="breadcrumb-item ">
	                        <span class="text-primary"><?php echo e($request->currency_symbol); ?></span>
	                    </li>
	                    <li> <h2> <?php echo e($request->net); ?> </h2> </li>
	                </ul>
	            </div>            
	            
	        </div>
	    </div>
	</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>