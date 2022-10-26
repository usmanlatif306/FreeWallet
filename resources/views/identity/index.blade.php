@extends('layouts.app')

@section('content')

<div class="row">
    @include('partials.sidebar')
    <div class="col-md-9 " style="padding-right: 0" id="#addFund">
        @include('flash')
        <div class="card">
            <div class="header">
                <h2><strong>{{__('Identity')}}</strong> {{__("Verification")}}
                    <a href="{{route('identity.camera',app()->getLocale())}}" class="ml-2">Camera Method</a>
                </h2>

            </div>
            <div class="body">
                <form action="{{route('identity.itentify', app()->getLocale())}}" method="post"
                    enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                        @if(Session::has('error'))
                        <div class="col-12">
                            <div class="alert alert-danger mx-1">
                                {{ Session::get('error')}}
                            </div>
                        </div>
                        @endif

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group {{ $errors->has('fornt_image') ? ' has-danger' : '' }}">
                                <label for="fornt_image">{{__('Document Front Image')}}</label>
                                <input type="file" id="fornt_image" class="form-control" name="fornt_image" required />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group {{ $errors->has('back_image') ? ' has-danger' : '' }}">
                                <label for="back_image">{{__('Document Back Image')}}</label>
                                <input type="file" id="back_image" class="form-control" name="back_image" required />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group {{ $errors->has('user_image') ? ' has-danger' : '' }}">
                                <label for="user_image">{{__('User Image')}}</label>
                                <input type="file" id="user_image" class="form-control" name="user_image" required />
                            </div>
                        </div>

                    </div>
                    <div class="clearfix border-bottom mt-3 mb-2"></div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{__('Proceed')}}</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection