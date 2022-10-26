@extends('layouts.app')

@section('content')
{{--  @include('partials.nav')  --}}
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
          @include('partials.flash')
          <div class="card">
            <div class="header">
              <h2><strong>{{__('How to proceed with')}} {{$transferMethod->name}} {{__('withdraws')}} </strong></h2>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-lg-12">
                    <div >
                        {!! $transferMethod->how_to_withdraw !!}
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
              <input type="hidden" name="wid" value={{$wid}}>
              <input type="hidden" name="tmid" value="{{$transferMethod->id}}">
              <div class="row">
              
                <div class="col-lg-7 col-xs-12">
                  <div class="row">
                    <div class="col">
                      <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                       <label for="amount">{{__('Amount')}}</label>
                       <input type="number" name="amount" class="form-control"  v-on:keyup="totalize" v-on:change="totalize" 
                         @if(Auth::user()->currentWallet()->is_crypto == 1 )
                            step="0.00000001" 
                           @else
                            step="0.01" 
                           @endif
                       >
                        @if ($errors->has('amount'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('amount') }}</strong> <span class="text-primary">{{$transferMethod->currency->symbol}}</span> 
                            </span>
                        @endif
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group {{ $errors->has('fee') ? ' has-error' : '' }}">
                       <label for="fee">Net [ <small class="bg-dark text-white"> {{__('gross')}} -  {{__('Fees')}} &nbsp;</span></small> ]</label>
                      {{-- <input type="number" name="fee" class="form-control" v-model="total"> --}}
                      <br>
                       <h2 style="margin-top: 0" ><span >@{{total}}</span> {{$transferMethod->currency->symbol}}</h2> 
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