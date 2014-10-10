@extends('layout.inner.master')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/loa.png", "Application For Leave of Absence") }}
							<h4 class="text-center">Application For Leave of Absence</h4>
						</a>
					</div>
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/cv.png", "Check Voucher") }}
							<h4 class="text-center">Petty Cash Voucher</h4>
						</a>
					</div>
				</div><!-- .row -->
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/obr.png", "Official Business Request") }}
							<h4 class="text-center">Official Business Request</h4>
						</a>
					</div>
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/ota.png", "Overtime Authorization") }}
							<h4 class="text-center">Overtime Authorization Form</h4>
						</a>
					</div>
				</div><!-- .row -->
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<a href="#" class="thumbnail">
							{{ HTML::image("img/pcv.png", "Petty Cash Voucher") }}
							<h4 class="text-center">Petty Cash Voucher</h4>
						</a>
					</div>
					<div class="col-xs-12 col-md-6">
						<a href="{{ URL::route('rfps.index') }}" class="thumbnail">
							{{ HTML::image("img/rfp.png", "Request For Payment") }}
							<h4 class="text-center">Request For Payment</h4>
						</a>
					</div>
				</div><!-- .row -->
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop