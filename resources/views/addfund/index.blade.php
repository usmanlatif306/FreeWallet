@extends('layouts.app')

@section('content')
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#addFund">
            @include('flash')
            <div class="card">
                <div class="header">
                    <h2><strong>{{ __('Add') }}</strong> {{ __('Fund') }}</h2>

                </div>
                <div class="body">
                    <form action="{{ route('addFunds', app()->getLocale()) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            @if (Session::has('success'))
                                <div class="col-12">
                                    <div class="alert alert-success mx-1">
                                        {{ Session::get('success') }}
                                    </div>
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="col-12">
                                    <div class="alert alert-danger mx-1">
                                        {{ Session::get('error') }}
                                    </div>
                                </div>
                            @endif
                            @if (!auth()->user()->identified)
                                <div class="col-12 mb-3">
                                    <div class="alert alert-danger mx-1">
                                        Your identify is not verified yet. Kindly verified your identity to add funds. To
                                        verify
                                        your identity <a href="{{ route('identity.index', app()->getLocale()) }}">click
                                            here</a>.
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="form-group {{ $errors->has('card') ? ' has-danger' : '' }}">
                                    <label for="amount">{{ __('Amount') }}</label>
                                    <input type="number" id="amount" class="form-control" name="amount" required
                                        placeholder="Amount" value="{{ old('amount') }}">
                                    <div id="message" class="text-primary">
                                        <small>Your enter amount will be converted to your wallet currency on today's
                                            rate.</small>
                                    </div>
                                    <div id="error" class="form-control-feedback text-danger d-none">
                                        Please enter valid amount
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="currency">{{ __('Currency') }}</label>
                                    <select name="currency" id="currency" class="form-control z-index show-tick"
                                        value="{{ old('currency') }}">
                                        @foreach ($currencies as $key => $name)
                                            <option value="{{ $key }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix border-bottom mt-3 mb-2"></div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" style="border-radius: 30px;" class="btn btn-primary"
                                    value="{{ __('Proceed') }}" {{ auth()->user()->identified ? '' : 'disabled' }}
                                    data-key="{{ config('services.stripe.key') }}" data-amount="" data-currency="usd"
                                    data-locale="auto" data-name="{{ setting('site.site_name') }}"
                                    data-description="Pay with Stripe to charge wallet"
                                    data-image="http://freewallets.co/storage/imgs/fav-icon.png" />
                                <!-- <input type="submit" class="btn btn-primary" value="{{ __('Proceed') }}"
                                        data-key="{{ config('services.stripe.key') }}" data-amount="" data-currency="usd"
                                        data-locale="auto" data-name="{{ setting('site.site_name') }}"
                                        data-description="Pay with Stripe to charge wallet"
                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png" /> -->
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
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script>
        $(function() {
            $('#currency').on('change', function(e) {
                $(':submit').data('currency', e.target.value)
            });
            $(':submit').on('click', function(event) {
                event.preventDefault();
                $('#error').addClass('d-none');
                var amount = $('#amount').val();
                if (amount) {
                    $(this).data('amount', amount * 100);
                    var $button = $(this),
                        $form = $button.parents('form');
                    var opts = $.extend({}, $button.data(), {
                        email: "{{ auth()->user()->email }}",
                        token: function(result) {
                            $form.append($('<input>').attr({
                                type: 'hidden',
                                name: 'stripeToken',
                                value: result.id
                            })).submit();
                        }
                    });
                    StripeCheckout.open(opts);
                } else {
                    $('#error').removeClass('d-none');
                }

            });
        });
    </script>
@endsection
@section('footer')
    @include('partials.footer')
@endsection
