@extends('layouts.app')

@section('content')
{{--  @include('partials.nav')  --}}
  <div class="row">
        @include('partials.sidebar')
		
		<div class="col-md-9 " style="padding-right: 0">
     @include('partials.flash')
  	 @if($withdrawals->total()>0)
     <div class="card">
        <div class="header">
            <h2><strong>{{__('My withdrawals')}}</strong></h2>
            
        </div>
        <div class="body">
            <div class="table-responsive">
              <table class="table table-striped"  style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th>{{__('Date')}}</th>
                      <th>{{__('Method')}}</th>
                      <th>{{__('Platform ID')}} ( {{__('your Id on choosen Method platform')}} )</th>
                      <th>{{__('Gross')}}</th>
                      <th>{{__('Fee')}}</th>
                      <th>{{__('Net')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($withdrawals as $withdrawal)
                      <tr>
                        <td>{{$withdrawal->created_at->format('d M Y')}} <br> @include ('withdrawals.partials.status')</td>
                        <td>{{$withdrawal->transferMethod->name}}</td>
                          <td>{{$withdrawal->platform_id}}</td>
                        <td>{{$withdrawal->gross()}}</td>
                        <td>{{$withdrawal->fee()}}</td>
                        <td>{{$withdrawal->net()}}</td>
                      </tr>
                    @empty
                    @endforelse
                </tbody>
                </table>
            </div>  
        </div>
         @if($withdrawals->LastPage() != 1)
              <div class="footer">
                  {{$withdrawals->links()}}
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