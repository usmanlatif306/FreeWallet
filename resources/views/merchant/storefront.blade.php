@extends('layouts.storefront')

@section('content')
<div class="container">

    @if($merchant)
   
    <div class="row justify-content-md-center">
    @include('merchant.partials.logandpay')
    </div>
    @endif
</div>
@endsection
@section('footer')
    @include('partials.footer')
@endsection