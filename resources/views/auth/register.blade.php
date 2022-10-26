<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>{{ setting('site.site_name') }} Sign Up</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css')}}">
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
                            <h4 class="logo"><img src="{{ setting('site.logo_url') }}" alt="Logo"> {{
                                strtoupper(setting('site.site_name')) }}</h4>
                            <h3>{{setting('site.site_name')}} {{__('is the faster, safer way to pay in the internet')}}
                            </h3>
                            <p>{{__('No matter where you shop, we keep your financial information secure')}}</p>
                            {{-- <div class="footer hidden">
                                <ul class="social_link list-unstyled">
                                    <li><a href="https://www.linkedin.com/company/thememakker/" title="LinkedIn"><i
                                                class="zmdi zmdi-linkedin"></i></a></li>
                                    <li><a href="https://www.facebook.com/thememakkerteam" title="Facebook"><i
                                                class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="http://twitter.com/thememakker" title="Twitter"><i
                                                class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="http://plus.google.com/+thememakker" title="Google plus"><i
                                                class="zmdi zmdi-google-plus"></i></a></li>
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
                        <div class="card-plain">
                            <div class="header">
                                <h5>{{__('Sign Up')}}</h5>
                                <span>{{__('Register a new membership')}}</span>
                            </div>
                            <form class="form" method="POST" action="{{ route('register', app()->getLocale()) }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ old('name') }}" placeholder="{{__('Enter User Name')}}" required
                                        autofocus>
                                    <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="input-group">
                                    <input type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="{{ old('email') }}" placeholder="{{__('Enter Email')}}"
                                        required>
                                    <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="CC">Select Your County</label>
                                    <select class="form-control z-index show-tick" placeholder="Select Your Contry"
                                        name="CC" id="CC">
                                        <option value="" data-prefix="">select</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->code}}" data-prefix="{{$country->prefix}}">
                                            {{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('CC'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('CC') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <input type="phone"
                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                        name="phone" value="{{ old('phone') }}" placeholder="{{__('Mobile Number')}}"
                                        id="phonenumber" required>
                                    <span class="input-group-addon"><i class="zmdi zmdi-phone"></i></span>
                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" placeholder="{{__('Password')}}" required>
                                    <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" placeholder="{{__('Repeat Password')}}" required>
                                    <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                                    @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="checkbox">
                                    <input id="terms" type="checkbox" name="terms">
                                    <label for="terms">{{__('I read and Agree to the')}} <a
                                            href="{{url('/')}}/{{app()->getLocale()}}/page/3">{{__('Terms of
                                            Usage')}}</a></label>
                                    @if ($errors->has('terms'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('terms') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="footer">
                                    <input type="submit" value="{{__('SIGN UP')}}"
                                        class="btn btn-primary btn-round btn-block">
                                </div>
                            </form>
                            <a class="link" href="{{url('/')}}/{{app()->getLocale()}}/login">{{__('You already have a
                                membership?')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="particles-js"></div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/js/libscripts.bundle.js') }}"></script>
    <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script type="text/javascript">
        $("#CC")
            .change(function () {
                $("#CC option:selected").each(function () {
                    $('#phonenumber').val($(this).data('prefix'));
                    //window.location.replace("{{url('/')}}/withdrawal/request/"+$(this).val());
                });
            });
    </script>
    <script src="{{ asset('assets/js/vendorscripts.bundle.js')}}"></script> <!-- slimscroll, waves Scripts Plugin Js -->
    <script src="{{ asset('assets/js/jquery.inputmask.bundle.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.multi-select.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{ asset('assets/js/particles.min.js')}}"></script>
    <script src="{{ asset('assets/js/particles.js')}}"></script>
    <script src="{{ asset('assets/js/mainscripts.bundle.js')}}"></script>
    <script src="{{ asset('assets/js/advanced-form-elements.js')}}"></script>

</body>

</html>

{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register', app()->getLocale()) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm
                                Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }}> <a
                                            href="{{url('/')}}/{{app()->getLocale()}}/page/3">{{ __('Agree with the
                                            terms and conditions.') }}</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @if ($errors->has('terms'))
                            <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('terms') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}