@extends('layouts.app')
@push('stylesheet')
<link rel="stylesheet" href="{{ asset('face/css/style.css') }}">
@endpush

@section('content')

<div class="row">
    @include('partials.sidebar')
    <div class="col-md-9 " style="padding-right: 0" id="#addFund">
        @include('flash')
        <div class="card">
            <div class="header">
                <h2><strong>{{__('Identity')}}</strong> {{__("Verification Through Camera")}}
                </h2>
            </div>
            <div class="body">
                <!-- faceki section start -->
                <section class="faceki-section d-flex flex-wrap align-items-center justify-content-center w-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-10 col-lg-6 col-xl-5 mx-auto">
                                <div class="faceki-card faceki-card-dark">
                                    <h2 class="faceki-card__title">Verify Your Identity</h2>
                                    <span class="faceki-card__sub-title">It will only take few seconds</span>
                                    <ul class="faceki-card__list" id="kyc_items">
                                    </ul>
                                    <button onclick="goToScannerPage()" class="faceki-card__btn">START</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- faceki section end -->

            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('face/js/faceki-startup.js') }}"></script>
@endpush