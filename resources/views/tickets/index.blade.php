@extends('layouts.app')

@section('content')
   {{-- @include('partials.nav') --}}
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
            <div class="card">
            <div class="header">
                <h2><strong>{{__('Tickets')}}</strong></h2>
            </div>
            <div class="body">
                  @if ($tickets->isEmpty())
                        <p>{{__('There are currently no tickets.')}}</p>
                    @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{__('Category')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Last Updated')}}</th>
                                    <th style="text-align:center" colspan="2">{{__('Actions')}}</th>
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
                                    @if($ticket->status != 'Closed')
                                        <td>
                                            <a href="{{ url('tickets/' . $ticket->ticket_id) }}" class="btn btn-primary">{{__('Comment')}}</a>
                                        </td>
                                        <td>
                                            <form action="{{ url('ticketadmin/close_ticket/' . $ticket->ticket_id) }}" method="POST">
                                                {!! csrf_field() !!}
                                                <button type="submit" class="btn btn-danger">{{__('Close')}}</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                        {{ $tickets->render() }}
                    @endif                       
                
            </div>
        </div>

            
        </div>
    </div>
@endsection