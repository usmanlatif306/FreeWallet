@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
    <div class="row">
        @include('profile.partials.sidenav')
		
		<div class="col-lg-9 ">
      <div class="card">
        <div class="header">
            <h2><strong>{{__('Proof of Identity')}}</strong> </h2>
            
        </div>
        <div class="body">
            <form class="needs-validation" enctype="multipart/form-data" method="POST" action="{{route('profile.identity.store', app()->getLocale())}}">
            {{csrf_field()}}
            <div class="row mb-3">
              <div class="col-md-12 mb-3">
                <label for="avatar">{{__('Upload a national id document issued by a legal government entity')}}</label>
                  <input type="file" class="form-control" name="document" id="avatar" >
                  @if ($errors->has('avatar'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('avatar') }}</strong>
                        </div>
                    @endif
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <label for="avatar">{{__('Document')}}</label>
                  </div>
                  @if(Auth::user()->profile != null )
                  <div class="card-body">
                    <img src="{{Auth::user()->profile->document()}}" alt="" class="img-fluid">
                  </div>
                  @endif
                </div>
              </div>
            </div>
                  
            <hr class="mb-4">
            <input class="btn btn-primary btn-lg btn-block" type="submit" value="{{__('Save')}}"></input>
          </form>                       
            
        </div>
    </div>
          
    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection
