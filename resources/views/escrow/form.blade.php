@extends('layouts.app')

@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">

          @include('flash')
           <div class="card bg-light" >
            <div class="header">
                <h2><strong> {{__('What is Escrow ?')}} </strong>  {{__('How does  it work ?')}}</h2>
                
            </div>
            <div class="body">
              <div class="clearfix"></div>
                <div class="row mb-5">
                  <div class="col-lg-12 ">
                      <label for=""></label>
                      <div  class="bg-white alert alert-secondary" role="alert" style="color: #383d41">
                          {!! setting('escrows.explainer_to_users') !!}
                      </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="card">
            <div class="header">
                <h2><strong>{{__("Transfer")}}</strong> {{__('Money')}} {{__('in escrow mode')}} </h2>
                
            </div>
            <div class="body">
              <form action="{{url('/')}}/{{app()->getLocale()}}/escrow" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('amount') ? ' has-danger' : '' }}">
                          <label for="amount">{{__('Amount')}}</label>
                          <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount')}}" required placeholder="5.00" pattern="[0-9]+([\.,][0-9]+)?" 
                          step="0.01" >
                           @if ($errors->has('amount'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </div>
                            @endif
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="email">{{__('User email')}}</label>
                        <div class="input-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                            <input type="text" class="form-control email" id="email" name="email" placeholder="Ex: example@example.com" required >
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
                        <div class="form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
                          <label for="description">{{__('Note for Recepient')}} | {{__('Your Deal Agreement')}} </label>
                          <textarea class="form-control" rows="5" id="description" name="description" placeholder="{{__('Write a note...')}}" required></textarea>
                           @if ($errors->has('description'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </div>
                            @endif
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col">
                        <input type="submit" class="btn btn-primary float-right" value="{{__('Start Escrow')}}">
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
$( "#currency" )
  .change(function () {
    $( "#currency option:selected" ).each(function() {
      window.location.replace("{{url('/')}}/{{app()->getLocale()}}/wallet/"+$(this).val());
  });
})
</script>

@endsection
@section('footer')
  @include('partials.footer')
@endsection
