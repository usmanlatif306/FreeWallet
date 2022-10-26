@extends('layouts.app')

@section('pre_content') 
 {{-- @include('partials.nav')  --}}
<div class="row">
  <div class="col">
    <div class="card">
      <div class="row">
        <div class="col">
         <h5 class="title p-4">{{$post->title}}</h5>
         </div>
      </div>
      <div class="row">
        <div class="col">
         <img src="{{Storage::url($post->image)}}">
         </div>
      </div>
      <div class="row">
       <div class="clearfix"></div>
          <div class="header">
             
              
          </div>
          <div class="body">
                                      
              <div class="col">
              {!! $post->body !!}
             </div>

          </div>
         
      </div>
    </div>
  </div>
</div>
    
@endsection

@section('footer')
	@include('partials.footer')
@endsection
