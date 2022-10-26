@extends('layouts.app')

@section('styles')
@include('wallet.styles')
@endsection


@section('content')
<div class="row clearfix">

    <div class="col-md-12 ">
        @include('partials.flash')
    </div>

</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{__('Create a wallet')}}</strong></h2>
            </div>
            <div class="body block-header">
                <div class="row">
                    <div class="col">
                        <ul id="glbreadcrumbs-two">
                            <li><a href="#"><strong>1.</strong> Select your wallet currency.</a></li>
                            <li><a href="#" class="a"><strong>2.</strong> {{__('Add a money transfer method to your
                                    wallet')}}.</a></li>
                            <li><a href="#" class="a"><strong>3.</strong> {{__('Finish your wallet creation')}}.</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    @foreach($currencies as $currency)
    <div class="col-lg-2 col-md-6 col-sm-12">
        <a href="{{url('/')}}/{{app()->getLocale()}}/transfer/{{$currency->id}}/methods">
            {{-- /wallet/create/{{$currency->id}} --}}
            <div class="card">
                <div class="body text-center">
                    <div class="chart easy-pie-chart-1" data-percent="67" style="margin-bottom:0px">
                        <span>
                            <img src="{{url('/').'/'.$currency->thumb}}" alt="user" class="rounded-circle">
                        </span>
                        <canvas height="100" width="100"></canvas>
                    </div>
                    <h6 style="margin-top: 10px">{{$currency->name}}</h6>

                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endsection

@section('footer')
@include('partials.footer')
@endsection