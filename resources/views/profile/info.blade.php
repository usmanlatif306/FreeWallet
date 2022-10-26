@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
    <div class="row">
        @include('profile.partials.sidenav')
		
		<div class="col-lg-9 ">
      <div class="card">
        <div class="header">
            <h2><strong>{{__('Personal Info')}}</strong></h2>
            
        </div>
        <div class="body">
            <form class="needs-validation" enctype="multipart/form-data" method="POST" action="{{route('profile.info.store', app()->getLocale())}}">
            {{csrf_field()}}
            <div class="row mb-3">
              <div class="col-md-3">
                <div class="card">
                  <div class="card-header">
                    <label for="avatar">{{__('Profile picture')}}</label>
                  </div>
                  <div class="card-body">
                    <img src="{{Auth::user()->avatar()}}" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12 mb-3">
                <label for="avatar">{{__('Upload a profile picture')}}</label>
                  <input type="file" class="form-control" name="avatar" id="avatar" >
                  @if ($errors->has('avatar'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('avatar') }}</strong>
                        </div>
                    @endif
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">{{__('First name')}}</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" value="{{Auth::user()->first_name}}" required="">
                @if ($errors->has('first_name'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </div>
                @endif
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">{{__('Last name')}}</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" value="{{Auth::user()->last_name}}" required="">
                @if ($errors->has('last_name'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </div>
                @endif
              </div>
            </div>

            <div class="mb-3">
              <label for="username">{{__('Username')}}</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" id="username" placeholder="Username" value="{{Auth::User()->name}}" disabled="">
                <div class="invalid-feedback" style="width: 100%;">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email">{{__('Email')}}</label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com" value="{{Auth::User()->email}}" disabled="">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

         

          
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">{{__('Save')}}</button>
          </form>                        
            
        </div>
    </div>

          
        </div>

    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection
