@extends('layouts.app')

@section('styles')
    @include('wallet.styles')
@endsection


@section('content')
	<div class="row clearfix">
		
		<div class="col-md-12 " >
        	@include('partials.flash')
    	</div>

    </div>

    <div class="row clearfix">
    	<div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>{{__('Investments')}}</strong></h2>
                </div>
                <div class="body block-header">
                    <div class="row">
                        <div class="col">
							<table class="table table-bordered table-striped table-hover js-basic-example dataTable no-footer" >
							   <thead>
							      <tr role="row">
							         <th class="sorting_desc">ID</th>
							         <th class="sorting">{{__('Package')}}</th>
							         <th class="sorting">{{__('Capital')}}</th>
							         <th class="sorting">{{__('Date')}}</th>
							         <th class="sorting">{{__('Elapses')}}</th>
							        
							         <th class="sorting">{{__('Status')}}</th>
							       
							         <th class="sorting">{{__('Total Earnings')}}</th>
							         <th class="sorting">{{__('Action')}}</th>
							      </tr>
							   </thead>
							   <tbody>
							   	@foreach($investments as $investment)
							      <tr role="row" @if( $loop->index % 2 == 0 ) class="odd" @else class="even" @endif>
							         <td class="sorting_1">{{$investment->id}}</td>
							         <td>{{$investment->Plan->name}}</td>
							         <td>{{$investment->capital}}</td>
							         <td>{{$investment->start}}</td>
							         <td>{{$investment->end}}</td>
							         
							         <td>@if( $investment->status == 1 )<span class="badge badge-primary"> Active </span> @else <span class="badge badge-default"> Complete </span> @endif</td>
							        
							         <td>{{$investment->earnings}}</td>
							         <td>
							         	<form method="post" action="{{url(app()->getLocale().'/')}}/investment/take_profit">
							         		<input type="hidden" name="inv_id" value="{{$investment->id}}">
							         		{{csrf_field()}}
							            	<input type="submit" class="btn btn-sm btn-neutral margin-0" value="{{__('Take Profits')}}">
							            </form>
							         </td>
							      </tr>
							    @endforeach
							   </tbody>
							</table>
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








