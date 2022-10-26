<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page') - {{ setting('site.site_name') }}</title>

    <!-- Styles -->
    <!-- Fonts -->
    {{--
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> --}}

    <!-- Styles -->
    {{--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Favicon-->
    <link rel="icon" href="{{ asset('storage/imgs/fav-icon.png')}}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-jvectormap-2.0.3.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/morris.min.css')}}" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css')}}">

    @stack('stylesheet')


    <style type="text/css">
        .jqstooltip {
            position: absolute;
            left: 0px;
            top: 0px;
            visibility: hidden;
            background: rgb(0, 0, 0) transparent;
            background-color: rgba(0, 0, 0, 0.6);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
            color: white;
            font: 10px arial, san serif;
            text-align: left;
            white-space: nowrap;
            padding: 5px;
            border: 1px solid white;
            box-sizing: content-box;
            z-index: 10000;
        }

        .jqsfield {
            color: white;
            font: 10px arial, san serif;
            text-align: left;
        }

        .bitcoin .body {
            position: absolute;
            word-break: break-all;
        }

        .remove {
            cursor: pointer;
        }

        .top_navbar {
            border-bottom: none
        }

        .navbar-nav>li>a .label-count {
            position: unset;
        }

        .menu_dark .sidebar {
            box-shadow: none !important;
        }

        @impersonating .top_navbar {
            background: #fff;
        }

        section.content::before {
            background: #fff;
        }

        .menu_dark .sidebar {
            background: #fff;
            box-shadow: none !important;
        }

        .navbar-nav>li>a .label-count {
            background-color: #50d38a;
            color: #fff;
        }

        .navbar-logo .navbar-brand span {
            color: #50d38a;
        }

        @endImpersonating @yield('styles')
    </style>


    @include('partials.footerstyles')

    <script src="{{ asset('js/vue.min.js') }}"></script>
    {{--
    @include('layouts.jquery')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
    --}}
</head>

<body class="{{setting('site.color_theme')}} menu_dark" id="app">
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('assets/images/logo.svg')}}" width="48" height="48" alt="sQuare"></div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    @include('layouts.topnavbar')
    @include('layouts.aside')
    <section class="content">
        <div class="container">
            <div class="row cleatfix">
                <div class="col-lg-12">
                    @yield('pre_content')
                </div>
            </div>
            @auth
            @if(Route::is('show.transfermethods') == false and Route::is('show.createwalletform') == false)
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="body block-header">
                            <div class="row">
                                <div class="col">
                                    <h2 style="padding-top: 10px">{{__('Welcome back')}} {{ Auth::user()->name }} !
                                    </h2>

                                </div>
                                <div class="text-right">
                                    <a href="{{route('addFundsForm', app()->getLocale())}}" class="btn btn-primary btn-round bg-blue float-right  m-l-10">{{__('Add
                                        Fund')}}</a>
                                </div>
                                <div class="text-right">
                                    <a href="{{route('show.currencies', app()->getLocale())}}" class="btn btn-primary btn-round bg-blue float-right  m-l-10">{{__('Add
                                        Wallet')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endauth
            @yield('content')
            @auth
            @if(Route::is('show.transfermethods') == false and Route::is('show.createwalletform') == false)
            <div class="row clearfix">

            </div>
            @endif
            @endauth
        </div>
        <!-- Scripts -->
        @yield('footer')
    </section>
    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/js/libscripts.bundle.js') }}"></script>
    <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="{{ asset('assets/js/vendorscripts.bundle.js')}}"></script> <!-- slimscroll, waves Scripts Plugin Js -->
    <script src="{{ asset('assets/js/morrisscripts.bundle.js')}}"></script><!-- Morris Plugin Js -->
    <script src="{{ asset('assets/js/jvectormap.bundle.js')}}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('assets/js/knob.bundle.js')}}"></script> <!-- Jquery Knob-->
    <script src="{{ asset('assets/js/mainscripts.bundle.js')}}"></script>
    <script src="{{ asset('assets/js/infobox-1.js')}}"></script>
    <script src="{{ asset('assets/js/index.js')}}"></script>
    <script src="{{ asset('assets/js/form-validation.js')}}"></script>
    @yield('js')
    @stack('scripts')

</body>

</html>