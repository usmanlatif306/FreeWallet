@if($myRequests)
@foreach($myRequests as $request)
	<div class="card">
	    <div class="header">
	        <h2><strong># {{$request->id}} :: Pending</strong> Money Request</h2>
	        <ul class="header-dropdown">
                <li class="remove">
                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                </li>
            </ul>
	        
	    </div>
	    <div class="body block-header">
	        <div class="row">
	            <div class="col">
	                <h2>To {{$request->from->name}} </h2>
	                <ul class="breadcrumb p-l-0 p-b-0 ">
	                    <li class="breadcrumb-item ">
	                        <span class="text-primary">{{$request->currency_symbol}}</span>
	                    </li>
	                    <li> <h2> {{$request->net}} </h2> </li>
	                </ul>
	            </div>            
	            {{-- 
	            <div class="col text-right">
	               <a href="https://devv2.bitmetical.com/deposit" class="btn btn-warning btn-round  float-right  m-l-10">Cancel</a>
	            </div>
	            --}}
	        </div>
	    </div>
	</div>
@endforeach
@endif