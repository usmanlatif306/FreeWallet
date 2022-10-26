@extends('layouts.app')

@section('content')
 {{--   @include('partials.nav') --}}
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9">
            <div class="card">
            <div class="header">
                <h2><strong>{{__('My Tickets')}}</strong></h2>
           
            </div>
            <div class="body">
                <div class="col mb-5">
                    <a href="{{url('/')}}/{{app()->getLocale()}}/new_ticket" class="btn btn-outline-primary float-right mb-4">{{__('Add New')}}</a>
                </div>  
                <div class="table-responsive">
                    @if ($tickets->isEmpty())
                        <p>{{__('You have not created any tickets.')}}</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{__('Category')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Last Updated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>
                                    @foreach ($categories as $category)
                                            {{ $category->name }}
                                    @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ url('tickets/'. $ticket->ticket_id) }}">
                                            #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                                        </a>
                                    </td>
                                    <td>
                                    @if ($ticket->status === 'Open')
                                        <span class="label label-success">{{ $ticket->status }}</span>
                                    @else
                                        <span class="label label-danger">{{ $ticket->status }}</span>
                                    @endif
                                    </td>
                                    <td>{{ $ticket->updated_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $tickets->render() }}
                    @endif
                    </div>                   
                
            </div>
        </div>

        </div>
    </div>
@endsection