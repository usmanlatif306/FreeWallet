<!doctype html>
<html class="no-js" lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo e(setting('site.site_name')); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo e(asset('landing/favicon.ico')); ?>" type="image/x-icon"> <!-- Favicon-->    
    <link rel="stylesheet" href="<?php echo e(asset('landing/css/normalize.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/css/jquery.fancybox.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/css/flexslider.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/css/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/css/queries.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/css/etline-font.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/bower_components/animate.css/animate.min.css')); ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="<?php echo e(asset('landing/landing/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')); ?>"></script>
    <style>
        .intro-icon {
            display: block;
            vertical-align: middle;
            padding: 6px 0 0 0;
            width: 100%;
            text-align: center;
        }
        .intro-content {
            display: inline-block;
            width: 100%;
        }
        .fixed {
            background-color: #50d38a;
        }
        .btn-white:hover, .btn-white:focus {
            color: #50d38a;
            border-color: #fff;
            background: #fff;
        }
        a.login:hover{
            color: #373D4A !important;
        }
    </style>
</head>
<body id="top" >
    <section class="hero-strip section-padding" style="margin-top: 0!important;background: #f3f4f8;padding: 0;">
        
    </section>
    <section class="blog-intro section-padding" id="demo">
        <div class="container">
            
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <h4>Regular User</h4>                    
                    <div class="demo-img"><a href="<?php echo e(route('demouser', app()->getLocale())); ?>" target="_blank" ><img alt="" src="<?php echo e(asset('assets/images/thumb1.jpg')); ?>" class="img-responsive"></a></div>
                    <div class="demo-links">
                        <a href="<?php echo e(route('demouser', app()->getLocale())); ?>" target="_blank" class="btn btn-fill btn-large btn-margin-right">Demo</a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <h4>Admin User</h4>                    
                    <div class="demo-img"><a href="https://admin.dxtrader.xyz/en/demo/admin" target="_blank" ><img alt=""  src="<?php echo e(asset('assets/images/thumb2.jpg')); ?>" class="img-responsive"></a></div>
                    <div class="demo-links">
                        <a href="https://admin.dxtrader.xyz/en/demo/admin" target="_blank" class="btn btn-fill btn-large btn-margin-right">Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo e(asset('landing/js/vendor/jquery-1.11.2.min.js')); ?>"><\/script>')</script>    
    <script src="<?php echo e(asset('landing/js/jquery.fancybox.pack.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/js/vendor/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/js/scripts.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/js/jquery.flexslider-min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/bower_components/classie/classie.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/bower_components/jquery-waypoints/lib/jquery.waypoints.min.js')); ?>"></script>
    
    <script>
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/59f5afbbbb0c3f433d4c5c4c/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
</body>
</html>

