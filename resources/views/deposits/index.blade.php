@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
<div class="row">
  @include('partials.sidebar')

  <div class="col-md-9 ">

    @if($deposits->total()>0)
    <div class="card">
      <div class="header">
        <h2><strong>{{__('My Deposits')}}</strong></h2>

      </div>
      <div class="body">
        <div class="table-responsive">
          <table class="table table-striped" style="margin-bottom: 0;">
            <thead>
              <tr>
                <th>{{__('Receipt')}}</th>
                <th>{{__('Date')}}</th>
                <th>{{__('Method')}}</th>
                <th>{{__('Gross')}}</th>
                <th>{{__('Fee')}}</th>
                <th>{{__('Net')}}</th>
                <th>{{__('Unique transaction id')}}</th>

              </tr>
            </thead>
            <tbody>
              @forelse($deposits as $deposit)
              <tr>
                <td><img src="{{url('/') . '/' .$deposit->transaction_receipt}}" alt="" class="rounded" loading="lazy"
                    style="width: 50px"></td>
                <td>{{$deposit->created_at->format('d M Y')}} <br> @include ('deposits.partials.status')</td>
                <td>{{$deposit->transferMethod->name}}</td>
                <td>{{$deposit->gross()}}</td>
                <td>{{$deposit->fee()}}</td>
                <td>{{$deposit->net()}}</td>
                <td>{{$deposit->unique_transaction_id}}</td>
              </tr>
              @empty

              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if($deposits->LastPage() != 1)
      <div class="footer">
        {{$deposits->links()}}
      </div>
      @else
      @endif
    </div>
    @endif

  </div>

</div>

@endsection

@section('footer')
@include('partials.footer')
@endsection