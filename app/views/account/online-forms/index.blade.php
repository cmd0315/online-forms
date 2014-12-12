@extends('layout.inner.master')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/leave-of-absence.png", "Application For Leave of Absence Form") }}
							<h4 class="text-center">Application For Leave of Absence</h4>
						</a>
					</div>
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/check-voucher.png", "Check Voucher Form") }}
							<h4 class="text-center">Petty Cash Voucher</h4>
						</a>
					</div>
				</div><!-- .row -->
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/official-business-request.png", "Official Business Request Form") }}
							<h4 class="text-center">Official Business Request</h4>
						</a>
					</div>
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/overtime-authorization.png", "Overtime Authorization Form") }}
							<h4 class="text-center">Overtime Authorization Form</h4>
						</a>
					</div>
				</div><!-- .row -->
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/petty-cash-voucher.png", "Petty Cash Voucher Form") }}
							<h4 class="text-center">Petty Cash Voucher</h4>
						</a>
					</div>
					<div class="col-xs-12 col-md-6">
						<a href="{{ URL::route('prs.index') }}" class="thumbnail">
							{{ HTML::image("img/payment-request.png", "Payment Request Form") }}
							<h4 class="text-center">Request For Payment</h4>
						</a>
					</div>
				</div><!-- .row -->
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop