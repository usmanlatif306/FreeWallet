<!doctype html>
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
                    <div class="col-lg-6 col-md-12 ">
                        <div class="company_detail">
                            <h4 class="logo"><img src="{{ setting('site.logo_url') }}" alt="Logo"> @if (setting('site.enable_text_logo'))
                                {{ strtoupper(setting('site.site_name')) }} @endif
                            </h4>
                            <h3>{{setting('site.site_name')}} {{__('is the faster, safer way to pay in the internet')}}</h3>
                            <p>{{__('No matter where you shop, we keep your financial information secure')}}</p>
                            {{-- <div class="footer hidden">
                        <ul  class="social_link list-unstyled">
                            <li><a href="https://www.linkedin.com/company/thememakker/" title="LinkedIn"><i class="zmdi zmdi-linkedin"></i></a></li>
                            <li><a href="https://www.facebook.com/thememakkerteam" title="Facebook"><i class="zmdi zmdi-facebook"></i></a></li>
                            <li><a href="http://twitter.com/thememakker" title="Twitter"><i class="zmdi zmdi-twitter"></i></a></li>
                            <li><a href="http://plus.google.com/+thememakker" title="Google plus"><i class="zmdi zmdi-google-plus"></i></a></li>
                        </ul>
                        <hr>
                        <ul class="list-unstyled">
                            <li><a href="http://thememakker.com/contact/" target="_blank">Contact Us</a></li>
                            <li><a href="http://thememakker.com/about/" target="_blank">About Us</a></li>
                            <li><a href="http://thememakker.com/services/" target="_blank">Services</a></li>
                            <li><a href="javascript:void(0);">FAQ</a></li>
                        </ul>
                    </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 offset-lg-1">
                        <div class="card-plain" style="max-width: 100%;">
                            <div class="header">
                                <h5>{{__('Two Factor Authentication')}}</h5>
                            </div>
                            <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            Enter the pin from Google Authenticator app:<br /><br />
                            <form class="form-horizontal" method="POST" action="{{ route('enable2fa', app()->getLocale()) }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('one_time_password-code') ? ' has-error' : '' }}">
                                    <label for="one_time_password" class="control-label">One Time Password</label>
                                    <input id="one_time_password" name="one_time_password" class="form-control" type="text" required />
                                </div>
                                <button class="btn btn-primary" type="submit">Authenticate</button>
                            </form>
                        </div>
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