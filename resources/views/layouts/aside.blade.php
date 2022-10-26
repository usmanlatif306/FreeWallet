<aside id="leftsidebar" class="sidebar h_menu">
    <div class="container">
        <div class="row clearfix">
            <div class="col-12">
                <div class="menu">
                    <ul class="list">
                        @guest
                        <li><a class="nav-link" href="{{ route('login', app()->getLocale()) }}">{{ __('Login') }}</a></li>
                        <li><a class="nav-link" href="{{ route('register', app()->getLocale()) }}">{{ __('Register') }}</a></li>
                        @else
                        <li class="header">MAIN</li>
                        <li class="{{ (Route::is('home') ? 'active open' : '') }}">
                            <a href="{{ route('home', app()->getLocale()) }}"><i class=" icon-layers"></i><span>{{__('Transactions')}}</span></a>
                        </li>
                        {{--
                        <li class="{{ (Route::is('exchange.form') ? 'active open' : '') }}">
                        <a href="{{url(app()->getLocale().'/')}}/exchange/first/0/second/0"><i class="icon-refresh"></i><span>{{__('Exchange')}}</span></a>
                        </li>
                        --}}
                        <li class="{{ (Route::is('sendMoneyForm') ? 'active open' : '') }}">
                            <a href="{{route('sendMoneyForm', app()->getLocale())}}"><i class="icon-arrow-right"></i><span>{{__('Send')}}</span></a>
                        </li>
                        <li class="{{ (Route::is('requestMoneyForm') ? 'active open' : '') }}">
                            <a href="{{route('requestMoneyForm',  app()->getLocale())}}"><i class="icon-arrow-left"></i><span>{{__('Request')}}</span></a>
                        </li>
                        <!-- <li class="{{ (Route::is('receivedMoneyForm') ? 'active open' : '') }}">
                            <a href="{{route('receivedMoneyForm',  app()->getLocale())}}"><i class="icon-arrow-left"></i><span>{{__('Received')}}</span></a>
                        </li> -->
                        <!-- <li class="{{ (Route::is('escrow') ? 'active open' : '') }}">
                            <a href="{{route('escrow',  app()->getLocale())}}"><i class="icon-arrow-right"></i><span>{{__('Escrow')}}</span></a>
                        </li> -->
                        <!-- <li>
                            <a href="javascript:void(0);" class="menu-toggle waves-effect waves-block"><i class="icon-bar-chart"></i><span>{{__('Invest')}}</span></a>
                            <ul class="ml-menu">
                                <li><a href="{{route('investmentplans',  app()->getLocale())}}" class=" waves-effect waves-block">{{__('Plans')}}</a></li>
                                <li><a href="{{route('myinvestments',  app()->getLocale())}}" class=" waves-effect waves-block">{{__('My Investments')}}</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="{{ (Route::is('mymerchants') ? 'active open' : '') }}">
                            <a href="{{ route('mymerchants',  app()->getLocale()) }}"><i class="icon-speedometer"></i><span>
                                    {{__('Integration')}}</span></a>
                        </li> -->
                        <li class="{{ (Route::is('mydeposits') ? 'active open' : '') }}">
                            <a href="{{route('mydeposits',  app()->getLocale())}}"><i class="icon-arrow-down"></i><span>
                                    {{__('My Deposits')}}</span></a>
                        </li>
                        <li class="{{ (Route::is('withdrawal.index') ? 'active open' : '') }}">
                            <a href="{{route('withdrawal.index',  app()->getLocale())}}"><i class="icon-arrow-up"></i><span>
                                    {{__('My Withdrawals')}}</span></a>
                        </li>
                        @if(Auth::user()->role_id != 1)
                        <!-- <li class="{{ (Route::is('my_vouchers') ? 'active open' : '') }}">
                            <a href="{{url( app()->getLocale().'/')}}/my_vouchers"><i class="icon-speedometer"></i><span>
                                    {{__('Vouchers')}}</span></a>
                        </li> -->
                        @endif
                        {{--
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-grid"></i><span>App</span></a>
                            <ul class="ml-menu">
                                <li><a href="mail-inbox.html">Inbox</a></li>
                                <li><a href="chat.html">Chat</a></li>
                                <li><a href="events.html">Calendar</a></li>
                                <li><a href="file-dashboard.html">File Manager</a></li>
                                <li><a href="contact.html">Contact list</a></li>
                                <li><a href="blog-dashboard.html">Blog</a></li>
                                <li><a href="app-ticket.html">Support Ticket</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-basket-loaded"></i><span>Ecommerce</span></a>
                            <ul class="ml-menu">
                                <li><a href="ec-dashboard.html">Dashboard</a></li>
                                <li><a href="ec-product.html">Products</a></li>
                                <li><a href="ec-product-detail.html">Product Detail</a></li>
                                <li><a href="ec-product-List.html">Product List</a></li>
                                <li><a href="ec-product-order.html">Orders</a></li>
                                <li><a href="ec-product-cart.html">Cart</a></li>
                                <li><a href="ec-checkout.html">Checkout</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-layers"></i><span>UI Elements</span></a>
                            <ul class="ml-menu">
                                <li><a href="ui-kit.html">UI KIT</a></li>                    
                                <li><a href="ui-alerts.html">Alerts</a></li>                    
                                <li><a href="ui-collapse.html">Collapse</a></li>
                                <li><a href="ui-colors.html">Colors</a></li>
                                <li><a href="ui-dialogs.html">Dialogs</a></li>
                                <li><a href="ui-icons.html">Icons</a></li>                    
                                <li><a href="ui-listgroup.html">List Group</a></li>
                                <li><a href="ui-mediaobject.html">Media Object</a></li>
                                <li><a href="ui-modals.html">Modals</a></li>
                                <li><a href="ui-notifications.html">Notifications</a></li>                    
                                <li><a href="ui-progressbars.html">Progress Bars</a></li>
                                <li><a href="ui-rangesliders.html">Range Sliders</a></li>
                                <li><a href="ui-sortablenestable.html">Sortable & Nestable</a></li>
                                <li><a href="ui-tabs.html">Tabs</a></li>
                                <li><a href="ui-waves.html">Waves</a></li>
                            </ul>
                        </li>
                        <li class="header">FORMS, CHARTS, TABLES</li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-doc"></i><span>Forms</span></a>
                            <ul class="ml-menu">
                                <li><a href="form-basic.html">Basic Elements</a></li>
                                <li><a href="form-advanced.html">Advanced Elements</a></li>
                                <li><a href="form-examples.html">Form Examples</a></li>
                                <li><a href="form-validation.html">Form Validation</a></li>
                                <li><a href="form-wizard.html">Form Wizard</a></li>
                                <li><a href="form-editors.html">Editors</a></li>
                                <li><a href="form-upload.html">File Upload</a></li>
                                <li><a href="form-img-cropper.html">Image Cropper</a></li>
                                <li><a href="form-summernote.html">Summernote</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-tag"></i><span>Tables</span></a>
                            <ul class="ml-menu">                        
                                <li><a href="table-normal.html">Normal Tables</a></li>
                                <li><a href="table-jquerydatatable.html">Jquery Datatables</a></li>
                                <li><a href="table-editable.html">Editable Tables</a></li>                                
                                <li><a href="table-color.html">Tables Color</a></li>
                                <li><a href="table-filter.html">Tables Filter</a></li>
                            </ul>
                        </li>            
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-bar-chart"></i><span>Charts</span></a>
                            <ul class="ml-menu">
                                <li><a href="morris.html">Morris</a></li>
                                <li><a href="flot.html">Flot</a></li>
                                <li><a href="chartjs.html">ChartJS</a></li>
                                <li><a href="sparkline.html">Sparkline</a></li>
                                <li><a href="jquery-knob.html">Jquery Knob</a></li>
                            </ul>
                        </li>
                        <li class="header">EXTRA COMPONENTS</li>                    
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-puzzle"></i><span>Widgets</span></a>
                            <ul class="ml-menu">
                                <li><a href="widgets-app.html">Apps Widgetse</a></li>
                                <li><a href="widgets-data.html">Data Widgetse</a></li>
                                <li><a href="widgets-chart.html">Chart Widgetse</a></li>
                            </ul>
                        </li>
                        <li> <a href="javascript:void(0);" class="menu-toggle"><i class="icon-lock"></i><span>Auth</span></a>
                            <ul class="ml-menu">
                                <li><a href="sign-in.html">Sign In</a></li>
                                <li><a href="sign-up.html">Sign Up</a></li>
                                <li><a href="forgot-password.html">Forgot Password</a></li>
                                <li><a href="404.html">Page 404</a></li>
                                <li><a href="403.html">Page 403</a></li>
                                <li><a href="500.html">Page 500</a></li>
                                <li><a href="503.html">Page 503</a></li>
                                <li><a href="page-offline.html">Page Offline</a></li>
                                <li><a href="locked.html">Locked Screen</a></li>
                            </ul>
                        </li>
                        <li> <a href="javascript:void(0);" class="menu-toggle"><i class="icon-folder-alt"></i><span>Pages</span></a>
                            <ul class="ml-menu">
                                <li><a href="blank.html">Blank Page</a></li>
                                <li><a href="teams-board.html">Teams Board</a></li>
                                <li><a href="projects.html">Projects List</a></li>
                                <li><a href="image-gallery.html">Image Gallery</a></li>
                                <li><a href="profile.html">Profile</a></li>
                                <li><a href="timeline.html">Timeline</a></li>
                                <li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
                                <li><a href="pricing.html">Pricing</a></li>
                                <li><a href="invoices.html">Invoices</a></li>
                                <li><a href="faqs.html">FAQs</a></li>
                                <li><a href="search-results.html">Search Results</a></li>
                                <li><a href="helper-class.html">Helper Classes</a></li>
                            </ul>
                        </li>
                        <li> <a href="javascript:void(0);" class="menu-toggle"><i class="icon-map"></i><span>Maps</span></a>
                            <ul class="ml-menu">
                                <li><a href="map-google.html">Google Map</a></li>
                                <li><a href="map-yandex.html">YandexMap</a></li>
                                <li><a href="map-jvectormap.html">jVectorMap</a></li>
                            </ul>
                        </li> 
                        --}}
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Right Sidebar -->
<aside id="rightsidebar" class="right-sidebar">
    <div class="slim_scroll">
        <div class="card">
            <h6>Demo Skins</h6>
            <ul class="choose-skin list-unstyled">
                <li data-theme="purple">
                    <div class="purple"></div>
                </li>
                <li data-theme="blue">
                    <div class="blue"></div>
                </li>
                <li data-theme="cyan">
                    <div class="cyan"></div>
                </li>
                <li data-theme="green" class="active">
                    <div class="green"></div>
                </li>
                <li data-theme="orange">
                    <div class="orange"></div>
                </li>
                <li data-theme="blush">
                    <div class="blush"></div>
                </li>
            </ul>
        </div>
        <div class="card theme-light-dark">
            <h6>Left Menu</h6>
            <button class="btn btn-default btn-block btn-round btn-simple t-light">Light</button>
            <button class="btn btn-default btn-block btn-round t-dark">Dark</button>
        </div>
    </div>
</aside>