@extends('layouts.app')

@section('content')
{{dd($wallet)}}
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " >
          <div class="row">
            <div class="col">
              <form action="{{route('post.exchange', app()->getLocale())}}" method="post" id="exchange_form" enctype="multipart/form-data">
                <div class="card">
                    <div class="header">
                        <h2><strong>{{__('Exchange')}}</strong> {{__('money between wallets')}}</h2>
                       
                    </div>
                    <div class="body">
                         {{csrf_field()}}
                          <input type="hidden" name="exchange_id" value="{{$exchange->id}}">
                          <div class="row">
                            <div class="col">
                              <div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
                                <div class="form-group">
                                  {{--
                                  <label for="first_currency_id"><h6>{{__('One')}} ( <span class="text-primary">1 {{$firstCurrency->symbol}}</span>) {{$firstCurrency->name}} </h6> </label>  <label for="second_currency_id"><h6>{{__('Exchanges')}} {{__('to')}} ( <span class="text-primary"> {{$exchange->exchanges_to_second_currency_value}} {{$secondCurrency->symbol}}</span>) {{$secondCurrency->name}} </h6></label>
                                  --}}
                                  <select class="form-control d-none" id="first_currency_id" name="first_currency_id">
                                        <option value="{{$firstCurrency->id}}" data-value="{{$firstCurrency->id}}" selected >{{$firstCurrency->name}}</option>
                                  </select>
                                  @if ($errors->has('first_currency_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_currency_id') }}</strong>
                                    </span>
                                @endif
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            {{--
                            <div class="col">
                              
                                  <div class="nav-item dropdown">
                                      <a id="CurrencyNavbarDropdown" class="nav-link dropdown-toggle btn btn-xs btn-outline btn-dark text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre=""> {{$firstCurrency->name}} <span class="badge badge-light">{{$firstCurrency->code}}</span></a>
                                      <div class="dropdown-menu" aria-labelledby="CurrencyNavbarDropdown">
                                         @forelse($firstCurrenciesExchages as $currency)
                                         @if($currency->firstCurrency->id != $firstCurrency->id)
                                        <a class="dropdown-item" href="{{url('/')}}/{{app()->getLocale()}}/wallet/{{$currency->firstCurrency->id}}"> 
                                        {{$currency->firstCurrency->name}}
                                        </a>
                                        @endif
                                         @empty
                                        @endforelse
                                      </div>
                                  </div>
                            </div>
                            --}}
                          </div>
                          <div class="clearfix"></div>
                          <div class="row">
                            
                            <div class="col">
                              <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                 <label for="amount"><h6>{{ Auth::user()->currentCurrency()->name }} {{__('Amount')}}</h6></label>
                                 <input type="text" name="amount" class="form-control" value="0"  v-on:keyup="exchange" v-on:change="exchange">
                                  @if ($errors->has('amount'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('amount') }}</strong>
                                      </span>
                                  @endif
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            
                            <div class="col">
                              <div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
                                <div class="form-group">
                                 
                                  <select class="form-control d-none" id="second_currency_id" name="second_currency_id">
                                        <option value="{{$secondCurrency->id}}" data-value="{{$secondCurrency->id}}" selected>{{$secondCurrency->name}}</option>
                                  </select>
                                  <div class="nav-item dropdown">
                                      <div id="CurrencyNavbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="" style="padding-left: 0"><label for="amount"><h6>{{__('Available')}} {{$secondCurrency->name}}  {{__('Amount')}}</h6></label> <span class="btn btn-primary btn-round bg-blue float-right btn-lg">{{ \App\Helpers\Money::instance()->value($wallet->amount, $wallet->Currency->symbol) }}</span></div>
                                      <div class="dropdown-menu" aria-labelledby="CurrencyNavbarDropdown">
                                         @forelse($secondCurrenciesExchanges as $currency)
                                         @if($currency->secondCurrency->id != $secondCurrency->id)
                                        <a class="dropdown-item" href="{{url('/')}}/{{app()->getLocale()}}/exchange/first/{{$firstCurrency->id}}/second/{{$currency->secondCurrency->id}}"> 
                                        {{$currency->secondCurrency->name}}
                                        </a>
                                        @endif
                                         @empty
                                        @endforelse
                                      </div>
                                  </div>
                                  @if ($errors->has('second_currency_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('second_currency_id') }}</strong>
                                    </span>
                                @endif
                                </div>
                              </div>
                            </div>
                            
                          </div>
                          <div class="row">
                            <div class="col">
                              <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                 <label for="amount"><h2 class=" mb-0 mt-0"><span>+</span> <span class="text-primary">@{{total}}</span><small>{{$secondCurrency->symbol}}</small></h2></label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <input type="submit" class="btn btn-primary btn-round btn-block btn-lg pull-right" value="{{__('Exchange')}}">
                            </div>
                          </div>
                          <div class="clearfix"></div>                       
                        
                    </div>
                </div>
              </form>
            </div>
          </div>
         
        </div>
    </div>

 
  
@endsection

@section('js')
@include('exchange.vue')
<script>
$( "#first_currency_id" )
  .change(function () {
    $( "#first_currency_id option:selected" ).each(function() {
      window.location.replace("{{url('/')}}/{{app()->getLocale()}}/exchange/first/" +$(this).val()+"/second");
  });
});

$( "#second_currency_id" )
  .change(function () {
    $( "#second_currency_id option:selected" ).each(function() {
      window.location.replace(window.location.href+'/'+$(this).val());
  });
})
  //   ;

</script>

@endsection
@section('footer')
  @include('partials.footer')
@endsection