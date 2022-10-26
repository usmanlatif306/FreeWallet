@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
  @if(setting('site.demo_mode'))
  <div class="row">
        @include('profile.partials.sidenav')
    
    <div class="col-lg-9 ">
      <div class="card">
          <div class="header">
              <h2><strong>{{__('Change Password')}}</strong></h2>
              
          </div>
          <div class="body">
            <p><span class="text-danger">{{__('Disabled in demo mode')}}</span></p>
          </div>
          
      </div>
          <h4 class="mb-3"></h4>

          
        </div>

    </div>
  @else
   <div class="row">
        @include('profile.partials.sidenav')
    
    <div class="col-lg-9 ">
      <div class="card">
          <div class="header">
              <h2><strong>{{__('Change Password')}}</strong></h2>
              
          </div>
          <div class="body">
             <form class="needs-validation" enctype="multipart/form-data" method="POST" action="{{route('profile.newpassword.store', app()->getLocale())}}">
            {{csrf_field()}}
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="newpassword">{{__('New password')}}</label>
                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="" value="" required="">
                @if ($errors->has('newpassword'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('newpassword') }}</strong>
                    </div>
                @endif
              </div>
              <div class="col-md-6 mb-3">
                <label for="newpasswordagain">{{__('Repeat your new password')}}</label>
                <input type="password" class="form-control" id="newpasswordagain" name="newpasswordagain" placeholder="" value="" required="">
                @if ($errors->has('newpasswordagain'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('newpasswordagain') }}</strong>
                    </div>
                @endif
              </div>
            </div>

            <div class="mb-3">
              <label for="oldpassword">{{__('Old Password')}}</label>
              <input type="password" class="form-control" id="oldpassword" name="oldpassword">
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">{{__('Save')}}</button>
          </form>                         
              
          </div>
      </div>
          <h4 class="mb-3"></h4>

          
        </div>

    </div>
  @endif
   
@endsection

@section('footer')
	@include('partials.footer')
@endsection
