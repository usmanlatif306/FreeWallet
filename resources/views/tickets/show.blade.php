@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
            <div class="card">
            <div class="header">
                <h2><strong>#{{ $ticket->ticket_id }}</strong>   - {{ $ticket->title }}</h2>
                
            </div>
            <div class="body">
               <div class="ticket-info">
                        <p>{{ $ticket->message }}</p>
                        <p>Categry: {{ $category->name }}</p>
                        <p>
                        @if ($ticket->status === 'Open')
                            Status: <span class="btn btn-success">{{ $ticket->status }}</span>
                        @else
                            Status: <span class="btn btn-danger">{{ $ticket->status }}</span>
                        @endif
                        </p>
                        <p>Created on: {{ $ticket->created_at->diffForHumans() }}</p>
                    </div>
                    <hr>

                    <div class="comments">
                        @foreach ($comments as $comment)
                            <div class="panel panel-@if($ticket->user->id === $comment->user_id) {{"default"}}@else{{"success"}}@endif">
                                <div class="panel panel-heading">
                                    <span class="text-primary">{{ $comment->user->name }}</span>
                                    <span class="pull-right">{{ $comment->created_at->format('Y-m-d') }}</span>
                                </div>

                                <div class="panel panel-body">
                                    <strong>{{ $comment->comment }} </strong>    
                                </div>
                            </div>
                              <hr>
                        @endforeach
                    </div>
                    
                    @if($ticket->status != 'Closed')
                    <hr>
                    <div class="comment-form">
                        <form action="{{ url('comment') }}" method="POST" class="form">
                            {!! csrf_field() !!}

                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                                @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    @endif                         
                
            </div>
        </div>
    </div>
@endsection