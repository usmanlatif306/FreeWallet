<!DOCTYPE html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title><?php echo e(setting('site.site_name')); ?> Sign In</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">

<!-- Custom Css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/color_skins.css')); ?>">
    <style type="text/css">
        .authentication .company_detail .logo img {
    width: auto;
    vertical-align: top;
}
    </style>
</head>
<body class="theme-green">
<div class="authentication">
    <div class="container">
        <div class="col-md-12 content-center">
            <div class="row clearfix">
                <div class="col-lg-6 col-md-12">
                    <div class="company_detail">
                        <h4 class="logo"><img src="<?php echo e(setting('site.logo_url')); ?>" height="42" alt="<?php echo e(setting('site.site_name')); ?>"> <span class="m-l-10"><?php echo e(setting('site.site_name')); ?></span></h4>
                        <h3>Verify your new <?php echo e(setting('site.title')); ?> account</h3>
                        
                        
                    </div>
                </div>                        
                <div class="col-lg-5 col-md-12 offset-lg-1">
                    <form class="form" action="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/otp" method="post">    
                    <?php echo e(csrf_field()); ?>

                    <div class="card-plain">
                        <div class="header">
                        
                            <?php echo $__env->make('flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>                             
                            <h5 class="mb-5">One Time Password</h5>
                            <span>To verify your account, we've sent a One Time Password to (OTP) to the email <?php echo e(Auth::user()-> email); ?> </span>
                        </div>
                        <div class="body">                  
                            <div class="input-group">
                                <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP">
                                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                            </div>
                            <?php if($errors->has('otp')): ?>
                                <span class="invalid-feedback d-block">
                                    <strong><?php echo e($errors->first('otp')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="footer">
                            <input type="submit" class="btn btn-primary btn-round btn-block" value="SUBMIT" >                            
                        </div>
                        <a href="<?php echo e(route('resend_otp', app()->getLocale())); ?>" class="link">Resend OTP</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="particles-js"></div>
</div>
<!-- Jquery Core Js --> 
<script src="<?php echo e(asset('assets/js/libscripts.bundle.js')); ?>"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
<script src="<?php echo e(asset('assets/js/vendorscripts.bundle.js')); ?>"></script> <!-- slimscroll, waves Scripts Plugin Js -->

<script src="<?php echo e(asset('assets/js/particles.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/particles.js')); ?>"></script>
</body>
</html>

