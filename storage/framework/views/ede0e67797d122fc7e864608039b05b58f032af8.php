

<?php if(session()->has('flash_message')): ?>


<div class="card bg-<?php echo e(session()->get('flash_message_level')); ?>">
    <div class="header">
    	<h2><i class="zmdi zmdi-alert-circle-o text-white"></i> <strong class="text-white"><?php echo e(__('Info')); ?></strong></h2>
        <ul class="header-dropdown">  
            <li class="remove">
                <a role="button" class="boxs-close "><i class="zmdi zmdi-close text-white" ></i></a>
            </li>
        </ul>
    </div>
    <div class="body block-header">
        <div class="row">
            <div class="col">
                <p class="text-white"> <?php echo session()->get('flash_message'); ?> </p>
            </div>   
        </div>
    </div>
</div>


<?php endif; ?>