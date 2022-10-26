
<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title><?php echo e(setting('site.site_name')); ?> Sign Up</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">

<!-- Custom Css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/color_skins.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-select.min.css')); ?>">
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
                    <h4 class="logo"><img src="<?php echo e(setting('site.logo_url')); ?>" alt="Logo"> <?php if(setting('site.enable_text_logo')): ?> 
                    <?php echo e(strtoupper(setting('site.site_name'))); ?> <?php endif; ?></h4>
                    <h3><?php echo e(setting('site.site_name')); ?> <?php echo e(__('is the faster, safer way to pay in the internet')); ?></h3>
                    <p><?php echo e(__('No matter where you shop, we keep your financial information secure')); ?></p>            
                    
                </div>
            </div>                        
            <div class="col-lg-5 col-md-12 offset-lg-1">
                <div class="card-plain">
                    <div class="header">
                        <h5><?php echo e(__('Sign Up')); ?></h5>
                        <span><?php echo e(__('Register a new membership')); ?></span>
                    </div>
                    <form class="form" method="POST" action="<?php echo e(route('register', app()->getLocale())); ?>">
                        <?php echo csrf_field(); ?>                        
                        <div class="input-group">
                            <input type="text" class="form-control <?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" placeholder="<?php echo e(__('Enter User Name')); ?>" required autofocus>
                            <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                            <?php if($errors->has('name')): ?>
                                <span class="invalid-feedback d-block">
                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="input-group">
                            <input type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('Enter Email')); ?>" required >
                            <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                            <?php if($errors->has('email')): ?>
                                <span class="invalid-feedback d-block">
                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="CC">Select Your County</label>
                            <select class="form-control z-index show-tick" placeholder="Select Your Contry" name="CC" id="CC">
                                 <option value="" data-prefix="">select</option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->code); ?>" data-prefix="<?php echo e($country->prefix); ?>"><?php echo e($country->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                             <?php if($errors->has('CC')): ?>
                                <span class="invalid-feedback d-block">
                                    <strong><?php echo e($errors->first('CC')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="input-group">
                            <input type="phone" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" name="phone" value="<?php echo e(old('phone')); ?>" placeholder="<?php echo e(__('Mobile Number')); ?>" id="phonenumber" required >
                            <span class="input-group-addon"><i class="zmdi zmdi-phone"></i></span>
                            <?php if($errors->has('phone')): ?>
                                <span class="invalid-feedback d-block">
                                    <strong><?php echo e($errors->first('phone')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" placeholder="<?php echo e(__('Password')); ?>"  required>
                            <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                            <?php if($errors->has('password')): ?>
                                <span class="invalid-feedback d-block">
                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="input-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="<?php echo e(__('Repeat Password')); ?>" required>
                            <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                            <?php if($errors->has('password_confirmation')): ?>
                                <span class="invalid-feedback d-block">
                                    <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="checkbox">
                            <input id="terms" type="checkbox" name="terms">
                            <label for="terms"><?php echo e(__('I read and Agree to the')); ?> <a href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/page/3"><?php echo e(__('Terms of Usage')); ?></a></label>
                            <?php if($errors->has('terms')): ?>
                                <span class="invalid-feedback d-block">
                                    <strong><?php echo e($errors->first('terms')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>  
                        
                    
                    <div class="footer">
                        <input type="submit" value="<?php echo e(__('SIGN UP')); ?>" class="btn btn-primary btn-round btn-block">
                    </div>
                    </form>
                    <a class="link" href="<?php echo e(url('/')); ?>/<?php echo e(app()->getLocale()); ?>/login"><?php echo e(__('You already have a membership?')); ?></a>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div id="particles-js"></div>
</div>

<!-- Jquery Core Js --> 
<script src="<?php echo e(asset('assets/js/libscripts.bundle.js')); ?>"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
<script type="text/javascript">
$( "#CC" )
  .change(function () {
    $( "#CC option:selected" ).each(function() {
        $('#phonenumber').val($(this).data('prefix'));
      //window.location.replace("<?php echo e(url('/')); ?>/withdrawal/request/"+$(this).val());
  });
});
</script>
<script src="<?php echo e(asset('assets/js/vendorscripts.bundle.js')); ?>"></script> <!-- slimscroll, waves Scripts Plugin Js -->
<script src="<?php echo e(asset('assets/js/jquery.inputmask.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.multi-select.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/bootstrap-tagsinput.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/particles.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/particles.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/mainscripts.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/advanced-form-elements.js')); ?>"></script>

</body>
</html>


