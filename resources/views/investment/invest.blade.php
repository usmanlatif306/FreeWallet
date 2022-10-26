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
                                    <li><a href="#" class="a"><strong>1.</strong> {{__('Join a plan')}}.</a></li>     
                                    <li><a href="#" ><strong>2.</strong> {{__('Set your investment capital')}}.</a></li>
                                    <li><a href="#" class="a"><strong>3.</strong> {{__('Invest')}}.</a></li>
                                </ul>
                            </div>            
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

<form method="post" action="{{url(app()->getLocale().'/')}}/investment/store">
	{{csrf_field()}}
    <div class="row clearfix">
    	<div class="col">	
			<div class="card">
		        <div class="header">
		            <h2>{{$plan->TransferMethod->currency->name}} {{__('capital')}} </h2>
		        </div>
		        <div class="body block-header">
		            <div class="row">
			                <div class="col">
			                	<div class="col-lg-12 ">
	                            	<label for="capital">Amount</label>
		                            <div class="" role="alert" style="color: #383d41">
		                                <div class="form-group ">
		                                  <input type="text" class="form-control" id="capital" name="capital" required="">
		                                </div>
		                            </div>
		                            <div class="row">
		                                <div class="col">
		                                    <input type="submit" class="btn btn-primary bg-blue btn-round float-right" value="{{__('Invest Capital')}}">
		                                </div>
		                            </div>
	                        	</div>
			                </div>
			                <input type="hidden" name="plan_id" value="{{$plan->id}}">          
		            </div>
		        </div>
		    </div>
	    </div>	
    </div>
</form>
@endsection

@section('footer')
	@include('partials.footer')
@endsection






