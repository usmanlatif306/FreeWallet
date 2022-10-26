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
                                <?php echo e(strtoupper(setting('site.site_name'))); ?> <?php endif; ?>
                            </h4>
                            <h3><?php echo e(setting('site.site_name')); ?> <?php echo e(__('is the faster, safer way to pay in the internet')); ?></h3>
                            <p><?php echo e(__('No matter where you shop, we keep your financial information secure')); ?></p>
                            
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 offset-lg-1">
                        <div class="card-plain" style="max-width: 100%;">
                            <div class="header">
                                <h5><?php echo e(__('Two Factor Authentication')); ?></h5>
                            </div>
                            <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                            <?php endif; ?>
                            <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                            <?php endif; ?>

                            <?php if($data['user']->loginSecurity == null): ?>
                            <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>

                            <form class="form-horizontal" method="POST" action="<?php echo e(route('generate2faSecret', app()->getLocale())); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Generate Secret Key to Enable 2FA
                                    </button>
                                </div>
                            </form>
                            <?php elseif(!$data['user']->loginSecurity->google2fa_enable): ?>
                            
                            <?php if($data['user']->loginSecurity->status === 'new'): ?>
                            1. Scan this QR code with your Google Authenticator App. Alternatively, you can use the code: <code><?php echo e($data['secret']); ?></code><br />
                            <?php echo $data['google2fa_url']; ?>

                            <!-- <img src="<?php echo $data['google2fa_url']; ?>" alt=""> -->
                            <br /><br />
                            2. Enter the pin from Google Authenticator app:<br /><br />
                            <form class="form-horizontal" method="POST" action="<?php echo e(route('enable2fa', app()->getLocale())); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group<?php echo e($errors->has('verify-code') ? ' has-error' : ''); ?>">
                                    <label for="secret" class="control-label">Authenticator Code</label>
                                    <input id="secret" type="text" class="form-control" name="secret" required>
                                    <?php if($errors->has('verify-code')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('verify-code')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Verify Code
                                </button>
                            </form>  
                            <?php else: ?>
                                
                              <form class="form-horizontal" method="POST" action="<?php echo e(route('enable2fa', app()->getLocale())); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group<?php echo e($errors->has('verify-code') ? ' has-error' : ''); ?>">
                                    <label for="secret" class="control-label">Enter the pin from Google Authenticator app:</label>
                                    <input id="secret" type="text" class="form-control" name="secret" required>
                                    <?php if($errors->has('verify-code')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('verify-code')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Verify Code
                                </button>
                            </form>  
                            <?php endif; ?>
                            
                            <?php elseif($data['user']->loginSecurity->google2fa_enable): ?>
                            <div class="alert alert-success">
                                2FA is currently <strong>enabled</strong> on your account.
                            </div>
                            <p>If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.</p>
                            <form class="form-horizontal" method="POST" action="<?php echo e(route('disable2fa', app()->getLocale())); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group<?php echo e($errors->has('current-password') ? ' has-error' : ''); ?>">
                                    <label for="change-password" class="control-label">Current Password</label>
                                    <input id="current-password" type="password" class="form-control" name="current-password" required>
                                    <?php if($errors->has('current-password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('current-password')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary ">Disable 2FA</button>
                            </form>
                            <?php endif; ?>
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