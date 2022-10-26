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
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="name">{{__('Name on Card')}}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"
                                    required placeholder="Name on card">
                                @if ($errors->has('name'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group {{ $errors->has('card') ? ' has-danger' : '' }}">
                                <label for="card">{{__('Card Number')}}</label>
                                <input type="number" class="form-control" id="card" name="card" value="{{old('card')}}"
                                    required placeholder="Card Number">
                                @if ($errors->has('card'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('card') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix my-3"></div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group {{ $errors->has('month') ? ' has-danger' : '' }}">
                                <label for="month">{{__('Expiry Month')}}</label>
                                <input type="number" class="form-control" id="month" name="month"
                                    value="{{old('month')}}" required placeholder="Expiry Month">
                                @if ($errors->has('month'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('month') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group {{ $errors->has('year') ? ' has-danger' : '' }}">
                                <label for="year">{{__('Expiry Year')}}</label>
                                <input type="number" class="form-control" id="year" name="year" value="{{old('year')}}"
                                    required placeholder="Expiry Year">
                                @if ($errors->has('year'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('year') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group {{ $errors->has('cvc') ? ' has-danger' : '' }}">
                                <label for="cvc">{{__('CVC')}}</label>
                                <input type="number" class="form-control" id="cvc" name="cvc" value="{{old('cvc')}}"
                                    required placeholder="CVC Number">
                                @if ($errors->has('cvc'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('cvc') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix border-bottom mt-3 mb-2"></div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" class="btn btn-primary" value="{{__('Proceed')}}">
                        </div>
                    </div>
                    <div class="clearfix"></div>
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