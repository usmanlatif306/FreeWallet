@extends('layouts.app')


@section('content')
{{--  @include('partials.nav')  --}}
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">

          <div class="card bg-light" >
            <div class="header">
                <h2><strong>{{__('How to proceed with')}} {{$transferMethod->name}} {{__('deposits')}} </strong></h2>
                
            </div>
            <div class="body">
              <div class="clearfix"></div>
                <div class="row mb-5">
                  <div class="col-lg-12 ">
                      <label for=""></label>
                      <div  class="bg-white alert alert-secondary" role="alert" style="color: #383d41">
                          {!! $transferMethod->how_to_deposit !!}
                      </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="card" >
            <div class="header">
                <h2><strong>{{  __('Deposit Request Form') }}</strong></h2>
                
            </div>
            <div class="body">
              <form action="{{route('post.credit', app()->getLocale())}}" method="post" enctype="multipart/form-data" >
                    {{csrf_field()}}
                    <input type="hidden" value="{{$transferMethod->id}}" name="tmid">
                    <input type="hidden" value="{{$wid}}" name="wid">
                    @if ($errors->has('wid'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('wid') }}</strong>
                              </span>
                          @endif
                          @if ($errors->has('tmid'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('tmid') }}</strong>
                              </span>
                          @endif
                    <div class="row bm-5">
                      <div class="col">
                        <div class="form-group {{ $errors->has('deposit_screenshot') ? ' has-error' : '' }}">
                          <label for="deposit_screenshot">{{$transferMethod->name}} {{__('Transaction Receipt Screenshot')}}</label>
                          <input type="file" class="form-control" id="deposit_screenshot" name="deposit_screenshot" value="{{ old('merchant_logo') }}" required>
                          @if ($errors->has('deposit_screenshot'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('deposit_screenshot') }}</strong>
                              </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row mb-5">
                       <div class="col">
                        <div class="form-group {{ $errors->has('unique_transaction_id') ? ' has-error' : '' }}">
                          <label for="unique_transaction_id">{{__('Unique')}} {{$transferMethod->name}} {{__('transaction id')}}</label>
                          <input type="text" class="form-control" id="unique_transaction_id" name="unique_transaction_id" value="{{ old('merchant_logo') }}" required>
                          @if ($errors->has('unique_transaction_id'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('unique_transaction_id') }}</strong>
                              </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="row mb-5">
                      <div class="col">
                        <div class="form-group {{ $errors->has('message') ? ' has-error' : '' }}">
                          <label for="message">{{__('Message to the reviewer')}} </label>
                          <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="{{__('Message to the reviewer')}}" style="border: 1px solid #eeee;"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="row mb-5">
                      <div class="col mt-5 ">
                        <input type="submit" class="btn btn-primary float-right" value="{{__('Save Deposit')}}">
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
$( "#deposit_method" )
  .change(function () {
    $( "#deposit_method option:selected" ).each(function() {
      window.location.replace("{{url('/')}}/{{app()->getLocale()}}/addcredit/"+$(this).val());
    });
  });
  $( "#deposit_currency" )
  .change(function () {
    $( "#deposit_currency option:selected" ).each(function() {
      window.location.replace("{{url('/')}}/{{app()->getLocale()}}/wallet/"+$(this).val());
    });
  })
</script>

@endsection