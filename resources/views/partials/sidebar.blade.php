 <div class="col-md-3">
     <div class="card info-box-2 l-seagreen">
         <!-- overflowhidden -->
         <div class="header">
             <h2> <strong style="color:#191f28">{{ __('Balance') }}</strong></h2>
             <ul class="header-dropdown">
                 <a href="{{ route('receivedMoneyForm', app()->getLocale()) }}" class="">
                     <span class="badge badge-success" style="border-color: white;">{{ __('Received') }}</span> </a>
                 <li class=" dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                         role="button" aria-haspopup="true" aria-expanded="false">
                         <span class="badge badge-success" style="border-color: white;">{{ __('Request') }}</span> </a>
                     <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
                         @foreach (\App\Models\Wallet::where('id', '!=', Auth::user()->currentWallet()->id)->where('user_id', Auth::user()->id)->get() as $wallet)
                             <li>


                             </li>
                         @endforeach

                         <li>
                             <a
                                 href="{{ url('/') }}/{{ app()->getLocale() }}/deposit/{{ Auth::user()->currentWallet()->id }}">{{ __('DEPOSIT') }}</a>
                             <hr style="margin: 0;">
                         </li>

                         <li>
                             <a
                                 href="{{ url('/') }}/{{ app()->getLocale() }}/payout/{{ Auth::user()->currentWallet()->id }}">{{ __('WITHDRAW') }}</a>
                             <hr style="margin: 0;">
                         </li>
                         {{--
                            @if (count(\App\Models\Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get()))
                             <li>
                                 <a href="{{url('/')}}/{{app()->getLocale()}}/exchange/first/0/second/0">{{ __('Convert Currency')}}
                         </a>
                 </li>
                 @endif
                 --}}
                     </ul>
                 </li>


             </ul>
         </div>
         <div class="body" style="padding-top: 0">
             <div class="content d-flex justify-content-between align-items-center">
                 @php
                     $balance = Auth::user()->balance() + Auth::user()->walletBalance();
                 @endphp
                 <div class="number " style="color: white !important">
                     {{ \App\Helpers\Money::instance()->value($balance, Auth::user()->currentCurrency()->symbol) }}
                 </div>
                 @if (auth()->user()->currentWallet()->is_crypto)
                     {!! QrCode::size(100)->generate(Auth::user()->address()) !!}
                 @endif

             </div>
             <div class="clearfix"></div>

             <div class="content">
                 <span>{{ Auth::user()->currentWallet()->currency->name }}</span>
                 <span style="font-size: 12px;">{{ Auth::user()->address() }}</span>
             </div>
         </div>
         {{-- <div id="sparkline16" class="text-center"><canvas width="403" height="390" style="display: inline-block; width: 403.328px; height: 390px; vertical-align: top;"></canvas></div> --}}
     </div>
     @if (Route::is('home'))

         @if (!empty($myEscrows))

             @foreach ($myEscrows as $escrow)
                 <div class="card">
                     <div class="header">
                         <h2><strong>On Hold</strong> #{{ $escrow->id }}</h2>
                         <ul class="header-dropdown">
                             <li class="remove">
                                 <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                             </li>
                         </ul>
                     </div>
                     <div class="body">
                         <h3 class="mb-0 pb-0">
                             - {{ \App\Helpers\Money::instance()->value($escrow->gross, $escrow->currency_symbol) }}
                         </h3>
                         Escrow money to <a
                             href="{{ url('/') }}/{{ app()->getLocale() }}/escrow/{{ $escrow->id }}"><span
                                 class="text-primary">{{ $escrow->toUser->name }}</span></a> <br>
                         <form action="{{ url('/') }}/{{ app()->getLocale() }}/escrow/release" method="post">
                             {{ csrf_field() }}
                             <input type="hidden" name="eid" value="{{ $escrow->id }}">
                             <input type="submit" class="btn btn-sm btn-round btn-primary btn-simple"
                                 value="{{ _('Release') }}">

                         </form>
                     </div>
                 </div>
             @endforeach

         @endif

         @if (!empty($toEscrows))

             @foreach ($toEscrows as $escrow)
                 <div class="card">
                     <div class="header">
                         <h2><strong>On Hold</strong> #{{ $escrow->id }}</h2>
                         <ul class="header-dropdown">
                             <li class="remove">
                                 <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                             </li>
                         </ul>
                     </div>
                     <div class="body">
                         <h3 class="mb-0 pb-0">
                             + {{ \App\Helpers\Money::instance()->value($escrow->gross, $escrow->currency_symbol) }}
                         </h3>
                         Escrow money from <a
                             href="{{ url('/') }}/{{ app()->getLocale() }}/escrow/{{ $escrow->id }}"><span
                                 class="text-primary">{{ $escrow->User->name }}</span></a>
                         <form action="{{ url('/') }}/{{ app()->getLocale() }}/escrow/refund" method="post">
                             {{ csrf_field() }}
                             <input type="hidden" name="eid" value="{{ $escrow->id }}">
                             <input type="submit" class="btn btn-sm btn-round btn-danger btn-simple"
                                 value="{{ _('refund') }}">
                         </form>
                     </div>
                 </div>
             @endforeach

         @endif

     @endif
     @if (count(Auth::user()->wallets()))
         @foreach (Auth::user()->wallets() as $someWallet)
             <div class="row ">
                 <div class="col">
                     <a href="{{ url('/') }}/{{ app()->getLocale() }}/wallet/{{ $someWallet->id }}">
                         <div class="card info-box-2" style="cursor: pointer;min-height: auto;">
                             <div class="header" style="padding-bottom: 0">
                                 <h2><strong>{{ $someWallet->currency->name }}</strong> {{ __('Balance') }}</h2>
                                 <ul class="header-dropdown">
                                     <li class="remove">

                                     </li>
                                 </ul>
                             </div>
                             <div class="body" style="padding-top: 0;padding-bottom: 0;">
                                 <div class="content">
                                     <div class="number">
                                         {{ \App\Helpers\Money::instance()->value($someWallet->amount, $someWallet->currency->symbol) }}
                                     </div>

                                 </div>
                             </div>
                         </div>
                     </a>
                 </div>
             </div>
         @endforeach
     @endif

     @if (Auth::user()->role_id == 1 or Auth::user()->is_ticket_admin)
         <div class="card hidden-sm">
             <div class="header">
                 <h2><strong>Admin</strong> area</h2>
                 <ul class="header-dropdown">
                     <li class="remove">
                         <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                     </li>
                 </ul>
             </div>
             <div class="body">
                 <h5 class="card-title">Howdy Mr. admin {{ Auth::user()->name }}</h5>
                 <p class="card-text">In this section you have links that are only visible to admins.</p>
                 <div class="list-group mb-2">
                     <a href="{{ route('makeVouchers', app()->getLocale()) }}"
                         class="list-group-item list-group-item-action {{ Route::is('makeVouchers') ? 'active' : '' }}">{{ __('Generate Vouchers') }}</a>
                     @if (Auth::user()->is_ticket_admin)
                         <a href="{{ url('ticketadmin/tickets') }}"
                             class="list-group-item list-group-item-action {{ Route::is('support') ? 'active' : '' }}">{{ __('Manage Tickets') }}</a>
                     @endif
                     @if (Auth::user()->role_id == 1)
                         <a href="{{ url('/') }}/{{ app()->getLocale() }}/update_rates"
                             class="list-group-item list-group-item-action ">{{ __('Update Exchange Rates') }}</a>
                     @endif
                 </div>
                 <a href="{{ url('/') }}/admin/dashboard" class="btn btn-primary btn-round">Go to admin
                     dashboard</a>

             </div>
         </div>
     @endif
     @if (Auth::user()->role_id == 3)
         <div class="card hidden-sm">
             <div class="header">
                 <h2><strong>Agent</strong> area</h2>
                 <ul class="header-dropdown">
                     <li class="remove">
                         <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                     </li>
                 </ul>
             </div>
             <div class="body ">
                 <h5 class="card-title">Howdy Mr. Agent {{ Auth::user()->name }}</h5>
                 <p class="card-text">In this section you have links that are only visible to Agents</p>
                 <div class="list-group mb-2">
                     <a href="{{ route('makeVouchers', app()->getLocale()) }}"
                         class="list-group-item list-group-item-action {{ Route::is('makeVouchers') ? 'active' : '' }}">{{ __('Recharge Vouchers') }}</a>
                 </div>
             </div>
         </div>
     @endif
     @if (!Route::is('exchange.form'))
         <div class="list-group">

         </div>
     @endif
 </div>
