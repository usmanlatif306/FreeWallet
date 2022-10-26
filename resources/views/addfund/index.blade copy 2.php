@extends('layouts.app')

@section('content')

<div class="row">
    @include('partials.sidebar')
    <div class="col-md-9 " style="padding-right: 0" id="#addFund">
        @include('flash')
        <div class="card">
            <div class="header">
                <h2><strong>{{__('Add')}}</strong> {{__("Fund")}}</h2>

            </div>
            <div class="body">
                <form action="{{route('addFunds', app()->getLocale())}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" style="display: none;"
                        data-key="{{ config('services.stripe.key') }}" data-amount="1000"
                        data-name="{{ setting('site.site_name') }}" data-description=""
                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto">
                        </script>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
<script>
    $("#currency")
        .change(function () {
            $("#currency option:selected").each(function () {
                window.location.replace("{{url('/')}}/{{app()->getLocale()}}/wallet/" + $(this).val());
            });
        })
</script>

@endsection
@section('footer')
@include('partials.footer')
@endsection