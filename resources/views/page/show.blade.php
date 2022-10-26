@extends('layouts.app')

@section('content') 
 {{-- @include('partials.nav')  --}}

    <div class="row">
    	<div class="col">
       <h1>{{$page->title}}</h1>
       </div>
    </div>
    <div class="row">
    	<div class="col">
       <img src="{{url('/')}}/storage/{{$page->image}}" alt="">
       </div>
    </div>
    <div class="row">
	   <div class="clearfix"></div>
     <div class="card">
    <div class="header">
       
        
    </div>
    <div class="body">
                                
        <div class="col">
        {!! $page->body !!}
       </div>

    </div>
</div>
       
    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection
