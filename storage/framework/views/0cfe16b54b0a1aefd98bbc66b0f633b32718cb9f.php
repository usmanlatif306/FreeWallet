
<!doctype html>
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
            <div class="col-lg-6 col-md-12 ">
                <div class="company_detail">
                    <h4 class="logo"><img src="<?php echo e(setting('site.logo_url')); ?>" alt="Logo"> <?php if(setting('site.enable_text_logo')): ?> 
                    <?php echo e(strtoupper(setting('site.site_name'))); ?> <?php endif; ?></h4>
                    <h3><?php echo e(setting('site.site_name')); ?> <?php echo e(__('is the faster, safer way to pay in the internet')); ?></h3>
                    <p><?php echo e(__('No matter where you shop, we keep your financial information secure')); ?></p>                        
                    
                </div>
            </div>                        
            <div class="col-lg-5 col-md-12  offset-lg-1">
                <div class="card-plain">
                    <div class="header">
                        <h5><?php echo e(__('Log in')); ?></h5>
                    </div>
                    <form class="form" method="POST" action="<?php echo e(route('login', app()->getLocale())); ?>">
                         <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input  id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('Email')); ?>" required autofocus>
                            <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                            <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" placeholder="<?php echo e(__('Password')); ?>" required>
                            <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                             <?php if($errors->has('password')): ?>
                                    <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div> 
                        <div class="checkbox float-left">
                            <input id="terms" type="checkbox">
                            <label for="terms"><?php echo e(__('Remember me')); ?></label>
                        </div>                         
                        <div class="clearfix"></div>
                        <div class="footer">
                            <input type="submit" class="btn btn-primary btn-round btn-block" value="<?php echo e(__('SIGN IN')); ?>">
                            <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/register" class="btn btn-primary btn-simple btn-round btn-block"><?php echo e(__('SIGN UP')); ?></a>
                        </div>
                     </form>
                    <a href="<?php echo e(route('password.request', app()->getLocale())); ?>" class="link"><?php echo e(__('Forgot Your Password?')); ?></a>
                </div>
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

