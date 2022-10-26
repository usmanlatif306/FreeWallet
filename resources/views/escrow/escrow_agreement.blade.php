@extends('layouts.app')

@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          <div class="card">
              <div class="header">
                 <h2><strong> {{__('Escrow ')}} </strong> | id: #{{$escrow->id}} </h2>
              </div>
              <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>{{__('Holding Period')}}</th>
                                <th>{{__('created_at')}}</th>
                                <th>{{__('Sender Email')}}</th>
                                <th>{{__('Receiver Email')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Gross')}}</th>
                                <th>{{__('Fee')}}</th>
                                <th>{{__('Net')}}</th>
                            </tr>
                        </thead>
                          <tr>
                            <td>{{setting('escrows.hpd')}} {{__('days')}}</td>
                            <td>{{$escrow->created_at->diffForHumans()}}</td>
                            <td>{{$sender->email}}</td>
                            <td>{{$receiver->email}}</td>
                            <td>{{$escrow->escrow_transaction_status}}</td>
                            <td>{{$escrow->currency_symbol}}{{$escrow->gross}}</td>
                            <td>{{$escrow->currency_symbol}}{{$escrow_fee}}</td>
                            <td>{{$escrow->currency_symbol}}{{$escrow->gross - $escrow_fee}}</td>
                            
                          </tr>
                    </table>
                </div>
              </div>
              <div class="header">
                <h2><strong> {{__('Agreement ')}} </strong> | {{__('The agreement between the Buyer and Seller')}} </h2>
              </div>
              <div class="body">
                <div class="row mb-5">
                  <div class="col-lg-12 ">
                      <label for=""></label>
                      <div  class="bg-white alert alert-secondary" role="alert" style="color: #383d41">
                          {{ $escrow->description }}
                      </div>
                  </div>
                </div>
              </div>
              @if($escrow->escrow_transaction_status != 'completed')
              <div class="body">
                <div class="float-right">
                  @if(Auth::user()->role_id == 1)
                    <form action="{{url('/')}}/{{app()->getLocale()}}/escrow/refund" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="eid" value="{{$escrow->id}}">
                        <input type="submit" class="btn  btn-round btn-danger" value="{{_('Refund Payment')}}">
                    </form>
                    <form action="{{url('/')}}/{{app()->getLocale()}}/escrow/release" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="eid" value="{{$escrow->id}}">
                        <input type="submit" class="btn  btn-round btn-primary bg-blue" value="{{_('Release Payment')}}">
                    </form>
                  @elseif(Auth::user()->id == $sender->id)
                    <form action="{{url('/')}}/{{app()->getLocale()}}/escrow/release" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="eid" value="{{$escrow->id}}">
                        <input type="submit" class="btn  btn-round btn-primary bg-blue" value="{{_('Release Payment')}}">
                    </form>
                  @elseif(Auth::user()->id == $receiver->id)
                    <form action="{{url('/')}}/{{app()->getLocale()}}/escrow/refund" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="eid" value="{{$escrow->id}}">
                        <input type="submit" class="btn  btn-round btn-danger" value="{{_('Refund Payment')}}">
                    </form>
                  @endif
                  </div>
                  <div class="clearfix"></div>
              </div>
              @endif
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
