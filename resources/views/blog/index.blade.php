@extends('layouts.app')

@section('pre_content') 

    <div class="row clearfix">
      <div class="col">
        <div class="tab-content">
          <div class="tab-pane card active">
            @forelse($posts as $post)
            <div class="body">
              <h5 class="title"><a target="_blank" href="{{url('/')}}/{{app()->getLocale()}}/{{$post->slug}}/{{$post->id}}" class="text-dark">{{$post->title}}</a></h5>
              <small>{{url('/')}}/{{app()->getLocale()}}/{{$post->slug}}/{{$post->id}}</small>
              <p class="m-t-10">{{$post->excerpt}}</p>
              <a class="m-r-20" target="_blank" href="{{url('/')}}/{{app()->getLocale()}}/{{$post->slug}}/{{$post->id}}">{{__('Read more')}}</a>
            </div>
            @empty

            @endforelse
          <ul class="body pagination  pagination-primary"></ul>
            
          </div>
        </div>
      </div>
    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection
