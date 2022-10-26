@extends('layouts.app')

@section('content')
{{--	@include('partials.nav')	--}}
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
        	{{--
			<div class="card">
			    <div class="header">
			        <h2><strong>{{__('Generate')}}</strong> {{__('Voucher')}}</h2>
			        <ul class="header-dropdown"> 
			            <li class="remove">
			                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
			            </li>
			        </ul>
			    </div>
			    <div class="body">
			         <form action="{{route('create_my_voucher', app()->getLocale())}}" method="POST" id="voucher_form">
	                			{{csrf_field()}}
			                	<div class="row">
		                			<div class="col-xs-12 col-lg-3">
		                				<div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
				                          <div class="form-group">
				                            <label for="deposit_method">{{__('Voucher Currency')}} [ <span class="text-primary">{{Auth::user()->currentCurrency()->code}}</span> ]</label>
				                            <select class="form-control" id="voucher_currency" name="voucher_currency">
				                              <option value="{{ Auth::user()->currentCurrency()->id }}" data-value="{{ Auth::user()->currentCurrency()->id}}" selected>{{ Auth::user()->currentCurrency()->name }} </option>
				                           
				                            </select>
				                            @if ($errors->has('voucher_currency'))
				                              <span class="help-block">
				                                  <strong>{{ $errors->first('voucher_currency') }}</strong>
				                              </span>
				                          	@endif
				                          </div>
				                        </div>
		                			</div>
		                			<div class="col-xs-12 col-lg-3">
		                				<div class="form-group {{ $errors->has('balance_amount') ? ' has-error' : '' }}">
					                        <label for="balance_amount">{{__('Balance Amount')}}</label>
					                       	<input type="number"  name="balance_amount"  id="balance_amount" class="form-control"  v-on:keyup="totalize"  v-on:change="totalize" required> 
					                          @if ($errors->has('balance_amount'))
					                              <span class="help-block">
					                                  <strong>{{ $errors->first('balance_amount') }}</strong>
					                              </span>
					                          @endif
					                    </div>
		                			</div>
		                			<div class="col-xs-12 col-lg-3">
		                				<div class="form-group {{ $errors->has('voucher_value') ? ' has-error' : '' }}">
					                        <label for="balance_amount">{{__('Voucher Value')}}</label>
					                        <h2 >@{{total}} {{Auth::user()->currentCurrency()->symbol}}</h2>
					                    </div>
		                			</div>
		                			<div class="col-xs-12 col-lg-3">
		                				<div class="form-group {{ $errors->has('submit') ? ' has-error' : '' }}"><label for="balance_amount">{{__('Add Voucher')}}</label>
		                					<input type="submit" value="{{__('Create Voucher')}}" class="btn btn-block btn-primary">
		                				</div>
		                			</div>
			                	</div>
	                		</form>                       
			    </div>
			</div>
			--}}
			
			<div class="card">
			    <div class="header">
			        <h2><strong>{{__('Load')}}</strong> {{__('Voucher')}}</h2>
			        <ul class="header-dropdown">
			            <li class="remove">
			                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
			            </li>
			        </ul>
			    </div>
			    <div class="body">
		           <form action="{{route('load_my_voucher', app()->getLocale())}}" method="POST" id="voucher_form">
            			{{csrf_field()}}
	                	<div class="row">
                			<div class="col">
                				<div class="form-group {{ $errors->has('balance_amount') ? ' has-error' : '' }}">
			                        <label for="voucher_code">{{__('Voucher code')}}</label>
			                       	<input type="text"  name="voucher_code" class="form-control"  required> 
			                          @if ($errors->has('voucher_code'))
			                              <span class="help-block">
			                                  <strong>{{ $errors->first('voucher_code') }}</strong>
			                              </span>
			                          @endif
			                    </div>
                			</div>
                			<div class="col">
                				<div class="form-group {{ $errors->has('submit') ? ' has-error' : '' }}"><label for="balance_amount">{{__('Load Voucher')}}</label>
                					<input type="submit" value="{{__('Load Voucher')}}" class="btn btn-block btn-primary">
                				</div>
                			</div>
	                	</div>
            		</form>   
			    </div>
			</div>
			<div class="card">
			    <div class="header">
			        <h2><strong>{{__('Generated')}}</strong> {{__('Vouchers')}}</h2>
			        <ul class="header-dropdown">
			            <li class="remove">
			                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
			            </li>
			        </ul>
			    </div>
			    <div class="body">
			        @if ($vouchers->isEmpty())
                    <div class="card">
                    	<div class="card-body">
                        <p>{{__('There are currently no vouchers.')}}</p>
                        </div>
                    </div>
                    @else
                    	{{$vouchers->links()}}
                    		<div class="table-responsive">
		                        <table class="table">
		                            <thead>
		                                <tr>
		                                    <th class="border-top-0">{{__('Id')}}</th>
		                                    <th class="border-top-0">{{__('Creared at')}}</th>
		                                    <th class="border-top-0">{{__('Was Loaded ?')}}</th>
		                                    <th class="border-top-0">{{__('Created by')}}</th>
		                                    <th class="border-top-0">{{__('Loaded by')}}</th>
		                                    <th class="border-top-0">{{__('Voucher code')}}</th>
		                                    <th class="border-top-0">{{__('Voucher value')}}</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                            	@foreach($vouchers as $voucher)
		                            	<tr>
		                            		<td>{{$voucher->id}}</td>
		                            		<td>{{$voucher->created_at->diffForHumans()}}</td>
		                            		<td>{{$voucher->wasLoaded()}}</td>
		                            		<td>{{$voucher->User->name}}</td>
		                            		<td>{{$voucher->LoaderName()}}</td>
		                            		<td>{{$voucher->voucher_code}}</td>
		                            		<td>{{$voucher->value()}}</td>
		                            	</tr>
		                            	@endforeach
		                            </tbody>
		                        </table>
		                    </div>
						{{$vouchers->links()}}
                    @endif   
			    </div>
			</div>
        </div>
    </div>
    
@endsection

@section('js')
	@include('vouchers.vue')
	<script>
    	$( "#voucher_currency" )
		  .change(function () {
		    $( "#voucher_currency option:selected" ).each(function() {
		      window.location.replace("{{url('/')}}/{{app()->getLocale()}}/wallet/"+$(this).val());
		  });
		})
    </script>
@endsection

@section('footer')
  @include('partials.footer')
@endsection