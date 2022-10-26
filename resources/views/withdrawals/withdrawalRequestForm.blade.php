@extends('layouts.app')

@section('content')
{{--  @include('partials.nav')  --}}
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
          @include('partials.flash')
          <div class="card">
            <div class="header">
              <h2><strong>{{__('About')}}</strong> {{$current_method->name}} {{__('withdrawals')}}</h2>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-lg-12">
                    <div >
                        {!! $current_method->comment !!}
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
          <div class="header">
            <h2><strong>{{__('Withdrawal Request')}}</strong></h2>
          </div>
          <div class="body">
            <form action="{{route('post.withdrawal', app()->getLocale())}}" method="post" enctype="multipart/form-data" id="withdrawal_form">
              {{csrf_field()}}
              
              <div class="row">
                <div class="col-lg-4 col-xs-12" style="display:none">
                  <div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
                    <div class="form-group">
                      <label for="deposit_method">{{__('Withdrawal Currency')}} [ <span class="text-primary">{{Auth::user()->currentCurrency()->code}}</span> ]</label>
                      <select class="form-control" id="withdrawal_currency" name="withdrawal_currency">
                        <option value="{{ Auth::user()->currentCurrency()->id }}" data-value="{{ Auth::user()->currentCurrency()->id}}" selected>{{ Auth::user()->currentCurrency()->name }} </option>
                        @forelse($currencies as $currency)
                            <option value="{{$currency->id}}" data-value="{{$currency->id}}">{{$currency->name}}</option>
                        @empty


                        @endforelse
                      </select>
                      @if ($errors->has('withdrawal_currency'))
                        <span class="help-block">
                            <strong>{{ $errors->first('withdrawal_currency') }}</strong>
                        </span>
                    @endif
                    </div>
                  </div>
                </div>
                <div class="col-lg-5 col-xs-12">
                  <div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
                    <div class="form-group">
                      <label for="withdrawal_method">{{__('Withdrawal Method')}}</label>
                      <select class="form-control" id="withdrawal_method" name="withdrawal_method">
                        @forelse($methods as $method)
                            <option value="{{$method->id}}" @if($method->name == $current_method->name) selected @endif>{{$method->name}}</option>
                        @empty


                        @endforelse
                      </select>
                      @if ($errors->has('withdrawal_method'))
                        <span class="help-block">
                            <strong>{{ $errors->first('withdrawal_method') }}</strong>
                        </span>
                    @endif
                    </div>
                  </div>
                </div>
                <div class="col-lg-7 col-xs-12">
                  <div class="row">
                    <div class="col">
                      <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                       <label for="amount">{{__('Amount')}}</label>
                       <input type="number" name="amount" class="form-control"  v-on:keyup="totalize" v-on:change="totalize" 
                         @if(Auth::user()->currentCurrency()->is_crypto == 1 )
                            step="0.00000001" 
                           @else
                            step="0.01" 
                           @endif
                       >
                        @if ($errors->has('amount'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('amount') }}</strong> <span class="text-primary">{{Auth::user()->currentCurrency()->symbol}}</span> 
                            </span>
                        @endif
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group {{ $errors->has('fee') ? ' has-error' : '' }}">
                       <label for="fee">Net [ <small class="bg-dark text-white"> {{__('gross')}} -  {{__('Fees')}} &nbsp;</span></small> ]</label>
                      {{-- <input type="number" name="fee" class="form-control" v-model="total"> --}}
                      <br>
                       <h2 style="margin-top: 0" ><span >@{{total}}</span> {{Auth::user()->currentCurrency()->symbol}}</h2> 
                        @if ($errors->has('fee'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fee') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col">
                  <div class="form-group {{ $errors->has('platform_id') ? ' has-error' : '' }}">
                   <label for="platform_id">{{$current_method->method_identifier_field__name}} </label>
                 <input type="text" name="platform_id" id="platform_id" class="form-control" required> 
                    @if ($errors->has('fee'))
                        <span class="help-block">
                            <strong>{{ $errors->first('platform_id') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-lg-12">
                  <input type="submit" class="btn btn-primary float-right" value="{{__('Request Withdrawal')}}">
                </div>
              </div>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('js')
@include('withdrawals.vue')
<script>
$( "#withdrawal_method" )
  .change(function () {
    $( "#withdrawal_method option:selected" ).each(function() {
      window.location.replace("{{url('/')}}/{{app()->getLocale()}}/withdrawal/request/"+$(this).val());
  });
});

$( "#withdrawal_currency" )
  .change(function () {
    $( "#withdrawal_currency option:selected" ).each(function() {
      window.location.replace("{{url('/')}}/{{app()->getLocale()}}/wallet/"+$(this).val());
  });
})
</script>

@endsection
@section('footer')
  @include('partials.footer')
@endsection