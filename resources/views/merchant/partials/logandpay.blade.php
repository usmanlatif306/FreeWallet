<div class="col-10 col-lg-push-1" style="margin-top: 20px">
    <div class="card card-primary">
        
        <div class="body">
            <div class="row">
                <div class="col">
                    <div class="media">
                        <div>
                            <div class="thumb hidden-sm m-r-20"> <img src="{{$merchant->logo}}" class="rounded-circle" alt="" style="width: 40px;"> </div>
                        </div>
                        <div class="media-body">
                            <div class="media-heading " style="margin-top: 10px !important;">
                                <span>{{$merchant->name}} </span>
                                <span class="badge badge-info">Merchant</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="mb-5 mt-5">{{__('Your Invoice')}}</h4> 
                        @include('merchant.invoice')
                     
                    <div class="row">
                        <div class="col">
                             <div class="mb-5 mt-2" style="padding: 20px 80px;">
                                <h4 style="text-align: center;">{{setting('site.site_name')}} {{__('is the faster, safer way to pay in the internet')}}</h4>
                                    <p style="text-align: center;"> {{__('No matter where you shop, we keep your financial information secure')}}</p>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                    
                    <h4 class="mb-5 mt-5">{{__('Pay With')}} {{setting('site.site_name')}}</h4>


                        <div class="card bg-light">
                            <div class="body">
                                @if(session()->get('PurchaseRequest')->attempts > 1 and  session()->get('PurchaseRequest')->attempts <= 5 )
                                    <div class="clearfix"></div>
                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>
                                            <a class="btn btn-link text-dark" href="{{ route('password.request', app()->getLocale()) }}">
                                                {{__('Forgot Your Password?')}}
                                            </a>
                                        </strong>
                                        {{ 5 - session()->get('PurchaseRequest')->attempts }} Attempts left
                                    </div>
                                @endif
                                @include('flash')
                                <form class="form-horizontal" method="POST" action="{{ route('logandpay', app()->getLocale()) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="ref" value="{{$ref}}">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        

                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="E-Mail Address">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        

                                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                    </div>

                                    {{-- 
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    --}}

                                    <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block btn-lg" style="font-weight: bold"> {{__('Make Payment')}}</button>
                                    </div>
                                </form>
                                <div class="clearfix"></div>
                                <hr style="margin-top: 20px; margin-bottom: 20px">
                                <div class="clearfix"></div>
                                <a href="{{url('/')}}/{{app()->getLocale()}}/register" class="btn btn-dark btn-block btn-lg" style="font-weight: bold; margin-bottom: 20px">{{__('Create An Account')}}</a>
                            </div>
                        </div>
                @if(
                    setting('payment-gateways.enable_paypal') == 're' 
                    or
                    setting('payment-gateways.enable_paystack') == 're'
                    or
                    setting('payment-gateways.enable_stripe') == 're'
                )
                    <h4 class="mb-5 mt-5">{{__('Pay With Tird Part')}} </h4>

                        <div class="card bg-light">
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table m-b-0">
                                        
                                        <tbody>
                                            <tr>
                                            @if(setting('payment-gateways.enable_paypal') == 1)
                                                <td style="border: 0" class="align-center">
                                                    <form method="post" action="{{url('/')}}/{{app()->getLocale()}}/merchant/storefront/paypal/{{$ref}}" id="paypal-form">
                                                        <input type="hidden" name="ref" value="{{$ref}}">   
                                                        @csrf
                                                        <a href="" onclick="event.preventDefault();
                                             document.getElementById('paypal-form').submit();">
                                                            <img style="width: 60px; border: 0" src="{{url('/')}}/storage/imgs/N7EVK0hQpVT3p0PrB95QIufkOOOmKXQ2WqiO2sPi.png" alt="" class="rounded">
                                                        </a>
                                                    </form>
                                                </td>
                                            @endif
                                            @if(setting('payment-gateways.enable_paystack') == 1)
                                                <td style="border: 0"  class="align-center">
                                                    <form method="post" action="{{url('/')}}/{{app()->getLocale()}}/merchant/storefront/paystack/{{$ref}}" id="paystack-form">
                                                        <input type="hidden" name="ref" value="{{$ref}}">   
                                                        @csrf
                                                        <a href="" onclick="event.preventDefault();
                                             document.getElementById('paystack-form').submit();">
                                                            <img style="width: 60px;border:0" src="{{url('/')}}/storage/imgs/smOMNQbvaoIgP8Y2TcA6DfgAdVdWsXe1Caww3aYV.png" alt="" class="rounded">
                                                        </a>
                                                    </form>
                                                </td>
                                            @endif
                                            @if(setting('payment-gateways.enable_stripe') == 1)
                                                <td style="border: 0"  class="align-center">
                                                    <img style="width: 60px;border:0" src="{{url('/')}}/storage/imgs/xNyqTMuGhvfDAQGIpWxfWrz9K49MEpYlvWJgLPeG.jpeg" alt="" class="rounded">
                                                </td>
                                            @endif   
                                            </tr>
                                            <tr>
                                            @if(setting('payment-gateways.enable_paypal') == 1)
                                                <td style="border:0"  class="align-center">PayPal</td>
                                            @endif
                                            @if(setting('payment-gateways.enable_paystack') == 1)
                                                <td style="border:0"  class="align-center">Paystack</td>
                                            @endif
                                            @if(setting('payment-gateways.enable_stripe') == 1)
                                                <td style="border:0"  class="align-center">Stripe</td>
                                            @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                @endif  
                </div>
            </div>
            
        </div>
    </div>
</div>