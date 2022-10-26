
@extends('layouts.app')


@section('content')
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " >
          {{--
          <div class="card" >
            <div class="header">
                <h2><strong>{{  __('Automatic Deposit Methods') }}</strong></h2>
                
            </div>
            <div class="body">
              @if(setting('payment-gateways.enable_stripe') == 1)
              <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/xNyqTMuGhvfDAQGIpWxfWrz9K49MEpYlvWJgLPeG.jpeg" alt="Generic placeholder image" style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">Stripe </strong><a href="{{url('/')}}/{{app()->getLocale()}}/buyvoucher/stripe" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @endif
              @if(setting('payment-gateways.enable_paypal') == 1)
              <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/8rciiMbLu2wKiZ8pScxIVIQvwmWnCxSJeZbZg9uC.png" alt="Generic placeholder image"  style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">PayPal </strong><a href="{{url('/')}}/{{app()->getLocale()}}/buyvoucher/paypal" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @endif
              @if(setting('payment-gateways.enable_paystack') == 1 )
              <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/smOMNQbvaoIgP8Y2TcA6DfgAdVdWsXe1Caww3aYV.png" alt="Generic placeholder image" style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">Paystack </strong><a href="{{url('/')}}/{{app()->getLocale()}}/buyvoucher/paystack" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @endif

            </div>
          </div>
          --}}
           <div class="card" >
            <div class="header">
                <h2><strong>{{  __('Manual Deposit Methods') }}</strong>@if($_ENV['APP_DEMO']) *Registered by admin @endif</h2>
                
            </div>
            <div class="body">
              @forelse($methods as $method)
                <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{$method->thumb}}" alt="Generic placeholder image"  style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">{{$method->name}}</strong><a href="{{url('/')}}/{{app()->getLocale()}}/addcredit/{{$method->id}}" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @empty

              @endforelse

            </div>
          </div>

        </div>
    </div>

@endsection
