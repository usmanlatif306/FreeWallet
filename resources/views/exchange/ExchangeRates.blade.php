@extends('layouts.app')

@section('content')

  <div class="row">
        @include('partials.sidebar')
         <div class="col-md-9 " >
  

 @if($show_exchange_rates_form)
            <div class="row">
              <div class="col">
                <div class="card ">
                  <div class="header">
                    <h2><strong>Set Exchange rates for</strong> {{ Auth::user()->currentCurrency()->name }}</h2> 
                    <ul class="header-dropdown">
                      <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                  </div>
                  <div class="body">
                      @foreach($currencies as $currency)

                      <form method="post" action="{{url('/')}}/{{app()->getLocale()}}/update_rates">
                      {{csrf_field()}}
                      <div class="form-group ">
                          @if(Auth::user()->currentCurrency()->code != $currency->code)
                            
                              <div class="row">
                                <div class="col-lg-2">
                                  <span class="float-right">1 <strong>{{ Auth::user()->currentCurrency()->code }}</strong> =</span>
                                </div>
                                <div class="col">
                                  <input type="text" name="amount" 

                                  @foreach($update_rates as $rate)

                                    @if($rate->secondCurrency->id == $currency->id)

                                      value="{{$rate->exchanges_to_second_currency_value}}" 
                                    
                                    @endif
                                  
                                  @endforeach

                                  class="form-control">
                                  
                                </div>
                                <div class="col">
                                  <label for="amount"><strong>{{$currency->code}}</strong></label>  <input type="submit" class="btn btn-primary btn-round btn-sm" style="margin-left: 20px" value="Update Exchange Rate"/>
                                </div>
                              </div>
                          @endif            
                      </div>

                      <input type="hidden" name="second_currency_id" value="{{$currency->id}}">
                      </form>
                      @endforeach
                  </div>
                </div>
              </div>
            </div>
          @endif
      </div>
  </div>
@endsection