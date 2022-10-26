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
                        <h2><strong>{{__('Start investing')}}</strong></h2>
                    </div>
                    <div class="body block-header">
                        <div class="row">
                            <div class="col">
                               <ul id="glbreadcrumbs-two">
                                    <li><a href="#" ><strong>1.</strong> {{__('Join a plan')}}.</a></li>     
                                    <li><a href="#" class="a"><strong>2.</strong> {{__('Set your investment capital')}}.</a></li>
                                    <li><a href="#" class="a"><strong>3.</strong> {{__('Invest')}}.</a></li>
                                </ul>
                            </div>            
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row clearfix">
	@foreach($plans as $plan)
	    <div class="col-lg-3 cool-md-6 col-sm-12">
		    <div class="card">
		    	<div class="header">
		    		<h2><strong>{{$plan->TransferMethod->currency->name}}</strong></h2>
		    	</div>
		        <ul class="pricing body">
		            <li><big>{{$plan->name}}</big></li>
		            <li>
		            	<span >{{$plan->min_investment}} {{$plan->TransferMethod->currency->code}} </span> {{__('MIN INVESTMENT')}}  
		            	
		            </li>
		            <li>
		            	 <span >{{$plan->max_investment}} {{$plan->TransferMethod->currency->code}}  </span>{{__('MAX INVESTMENT')}}
		            </li>
		            <li>
		                <h3>{{$plan->min_profit_percentage}} % {{__('ROI')}}</h3>
		                 <span>{{$plan->withdraw_interval_days}} {{__('Days')}}</span> {{__('WITHDRAW INTERVAL')}}
		            </li>
		            <li>{{__('Capital Accessible After Investment Elapses')}}</li>
		            <li><a href="{{url(app()->getLocale().'/')}}/investment/plan/{{$plan->id}}" class="btn btn-primary btn-round btn-simple">Join Now</a></li>
		        </ul>
		    </div>
		</div>
    @endforeach
    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection






