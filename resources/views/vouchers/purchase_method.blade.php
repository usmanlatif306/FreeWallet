@extends('layouts.app')

@section('content')
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
            <div class="row">
            	<div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="67"> <span><img src="{{url('/')}}/storage/QB3VHPpjoKukys3Y9ANkZ8xux6mluwWUWzdFUIyy.png" alt="user" class="rounded-circle"></span> <canvas height="100" width="100"></canvas></div>
                            <h6>{{__('PayPal')}}</h6>
                            <a href="{{url('/')}}/{{app()->getLocale()}}/buyvoucher/paypal" class="btn btn-primary">Get Voucher</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="67"> <span><img src="{{url('/')}}/storage/X6RRPo48yvxo8OMD1t58sppKHWoojNRI8N8ZHKnW.png" alt="user" class="rounded-circle"></span> <canvas height="100" width="100"></canvas></div>
                            <h6>{{__('Paystack')}}</h6>
                            <a href="{{url('/')}}/{{app()->getLocale()}}/buyvoucher/paystack" class="btn btn-primary">Get Voucher</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('js')

@endsection

@section('footer')
  @include('partials.footer')
@endsection