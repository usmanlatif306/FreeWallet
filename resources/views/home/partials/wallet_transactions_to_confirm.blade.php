
@if($wallet_transactions_to_confirm->currentPage() <= $wallet_transactions_to_confirm->lastPage() and $wallet_transactions_to_confirm->total() > 0 )

  <div class="panel panel-default">
      <div class="panel-body">
        <div class="card user-account">
          <div class="header">
              <h2><strong>Pending</strong> Wallet Transactions</h2>
              
              <ul class="header-dropdown">
                  
                  <li class="remove">
                      <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                  </li>
              </ul>
              
          </div>
          <div class="body">
              <div class="table-responsive">
                  <table class="table m-b-0">
                      <thead>
                          <tr>
                              <th>id</th>
                              <th>{{__('Date')}}</th>
                              <th>{{__('Name')}}</th>
                              <th>{{__('Gross')}}</th>
                              <th>{{__('Fee')}}</th>
                              <th>{{__('Net')}}</th>
                              <th>{{__('Status')}}</th>
                          </tr>
                      </thead>
                      <tbody>
                        @forelse($wallet_transactions_to_confirm as $transaction)
                          <tr>
                            <td>{{$transaction->id}}</td>
                            <td>{{$transaction->created_at->format('d M Y')}} <br> @include('home.partials.status')</td>
                            
                            <td>
                            @include('home.partials.name')</a></td>
                            <td>{{$transaction->gross()}}</td>
                            <td>{{$transaction->fee()}}</td>
                            <td>{{$transaction->net()}}</td>

                            <td>
                              <span class="badge badge-primary">Pending</span>
                            </td>
                          </tr>
                        @empty
                        @endforelse 
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
      </div>
      @if($wallet_transactions_to_confirm->LastPage() != 1)
        <div class="panel-footer">
            {{$transactions->links()}}
        </div>
      @else
      @endif
  </div>
@endif