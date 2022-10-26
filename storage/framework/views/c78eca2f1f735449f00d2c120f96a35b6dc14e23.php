<?php if(request()->server('HTTP_USER_AGENT') == "AppWebView"): ?>
	<?php echo $__env->make('_mobile.home.APP', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
	<?php echo $__env->make('_mobile.home.PWA', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?> 