@extends('layouts.app')

@section('content')

<div class="row">
  @include('partials.sidebar')
  <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
    @include('flash')
    <div class="card">
      <div class="header">
        <h2><strong>{{__('Received')}}</strong> {{__("Money")}}</h2>

      </div>
      <div class="body">
        <form action="{{route('receivedMoneyHash', app()->getLocale())}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label for="deposit_method">{{__('Currency')}} [ <span class="text-primary">{{Auth::user()->currentCurrency()->code}}</span> ]</label>
                  <select class="form-control" id="currency" name="currency">
                    <option value="{{ Auth::user()->currentCurrency()->id }}" data-value="{{ Auth::user()->currentCurrency()->id}}" selected>{{ Auth::user()->currentCurrency()->name }} </option>
                    {{--
                            @forelse($currencies as $currency)
                                <option value="{{$currency->id}}" data-value="{{$currency->id}}">{{$currency->name}}</option>
                    @empty


                    @endforelse
                    --}}
                  </select>
                  @if ($errors->has('currency'))
                  <span class="help-block">
                    <strong>{{ $errors->first('currency') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="form-group {{ $errors->has('amount') ? ' has-danger' : '' }}">
                <label for="amount">{{__('Amount')}}</label>
                <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount')}}" required placeholder="5.00" pattern="[0-9]+([\.,][0-9]+)?" @if(Auth::user()->currentCurrency()->is_crypto == 1 )
                step="0.00000001"
                @else
                step="0.01"
                @endif
                >
                @if ($errors->has('amount'))
                <div class="form-control-feedback">
                  <strong>{{ $errors->first('amount') }}</strong>
                </div>
                @endif
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label for="email">{{__('Currency Hash')}}</label>
              <div class="input-group {{ $errors->has('hash') ? ' has-danger' : '' }}">
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                <input type="text" class="form-control" name="hash" placeholder="Currency Hash" required>
                @if ($errors->has('email'))
                <div class="form-control-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
                @endif
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col">
              <input type="submit" class="btn btn-primary float-right" value="{{__('Received Money')}}">
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
<script>
  $("#currency")
    .change(function() {
      $("#currency option:selected").each(function() {
        window.location.replace("{{url('/')}}/{{app()->getLocale()}}/wallet/" + $(this).val());
      });
    })
</script>

@endsection
@section('footer')
@include('partials.footer')
@endsection