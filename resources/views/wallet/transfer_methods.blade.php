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
                            <li><a href="#" class="a"><strong>1.</strong> Select your wallet currency.</a></li>
                            <li><a href="#"><strong>2.</strong> Add a money transfer method to your wallet.</a></li>
                            <li><a href="#" class="a"><strong>3.</strong> Finish your wallet creation.</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    @foreach($methods as $method)
    <div class="col-lg-3 col-md-4 col-sm-12">
        <a href="{{url('/')}}/{{app()->getLocale()}}/wallet/create/{{$method->id}}">
            <div class="card product_item">
                <div class="body text-center">
                    <div class="cp_img">
                        <img src="{{url('/').'/'.$method->thumbnail}}" alt="Product" class="img-fluid">

                    </div>
                    <h6 style="margin-top: 10px">{{$method->name}}</h6>

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