@extends('layouts.app')

@section('content')

<div class="row clearfix">
	@include('partials.sidebar')

	<div class="col-md-9 ">
		@include('partials.flash')

		@include('home.partials.requests')

		@include('home.partials.transactions_to_confirm')

		@include('home.partials.wallet_transactions_to_confirm')

		@include('home.partials.transactions')

	</div>

</div>
@endsection

@section('footer')
@include('partials.footer')
@endsection