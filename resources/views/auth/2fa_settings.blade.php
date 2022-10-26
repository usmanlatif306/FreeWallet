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
                            @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            @if($data['user']->loginSecurity == null)
                            <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>

                            <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret', app()->getLocale()) }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Generate Secret Key to Enable 2FA
                                    </button>
                                </div>
                            </form>
                            @elseif(!$data['user']->loginSecurity->google2fa_enable)
                            {{-- check status if it is new then show qr code  --}}
                            @if ($data['user']->loginSecurity->status === 'new')
                            1. Scan this QR code with your Google Authenticator App. Alternatively, you can use the code: <code>{{ $data['secret'] }}</code><br />
                            {!! $data['google2fa_url'] !!}
                            <!-- <img src="{!! $data['google2fa_url'] !!}" alt=""> -->
                            <br /><br />
                            2. Enter the pin from Google Authenticator app:<br /><br />
                            <form class="form-horizontal" method="POST" action="{{ route('enable2fa', app()->getLocale()) }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="secret" class="control-label">Authenticator Code</label>
                                    <input id="secret" type="text" class="form-control" name="secret" required>
                                    @if ($errors->has('verify-code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify-code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Verify Code
                                </button>
                            </form>  
                            @else
                              {{-- if status is created then enter code --}}  
                              <form class="form-horizontal" method="POST" action="{{ route('enable2fa', app()->getLocale()) }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="secret" class="control-label">Enter the pin from Google Authenticator app:</label>
                                    <input id="secret" type="text" class="form-control" name="secret" required>
                                    @if ($errors->has('verify-code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify-code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Verify Code
                                </button>
                            </form>  
                            @endif
                            
                            @elseif($data['user']->loginSecurity->google2fa_enable)
                            <div class="alert alert-success">
                                2FA is currently <strong>enabled</strong> on your account.
                            </div>
                            <p>If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.</p>
                            <form class="form-horizontal" method="POST" action="{{ route('disable2fa', app()->getLocale()) }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="change-password" class="control-label">Current Password</label>
                                    <input id="current-password" type="password" class="form-control" name="current-password" required>
                                    @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary ">Disable 2FA</button>
                            </form>
                            @endif
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