<!DOCTYPE html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>{{ setting('site.site_name') }} Sign In</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
 <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">

<!-- Custom Css -->
  <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css')}}">
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
                        <h4 class="logo"><img src="{{setting('site.logo_url')}}" height="42" alt="{{ setting('site.site_name') }}"> <span class="m-l-10">{{ setting('site.site_name') }}</span></h4>
                        <h3></h3>
                        
                        
                    </div>
                </div>                        
                <div class="col-lg-5 col-md-12 offset-lg-1">
                    <form class="form" action="{{url('/')}}/{{app()->getLocale()}}/otp" method="post">    
                    {{csrf_field()}}
                    <div class="card-plain">
                        <div class="header">
                        
                          <div class="company_detail">
                        <h4 class="logo"><img src="{{$user->avatar()}}" height="62" alt="{{ setting('site.site_name') }}"> <span class="m-l-10">{{ setting('site.site_name') }}</span></h4>
                        <h3>@ {{$user->name}}</h3>
                        
                        
                    </div>
                        </div>
                        <div class="body">                  
                             {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(280)->generate($QrCode); !!}
                        </div>
                       
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="particles-js"></div>
</div>
<!-- Jquery Core Js --> 
<script src="{{ asset('assets/js/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
<script src="{{ asset('assets/js/vendorscripts.bundle.js')}}"></script> <!-- slimscroll, waves Scripts Plugin Js -->

<script src="{{ asset('assets/js/particles.min.js')}}"></script>
<script src="{{ asset('assets/js/particles.js')}}"></script>
</body>
</html>

