@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('payment-request') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-xs-4 col-md-3 col-md-offset-1">
						<i>
							<h4 class="text-warning">Description</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
						</i>
						<a href="{{ URL::route('rfps.create') }}" class="btn btn-warning"> Make Request</a>
						<a href="#" class="btn btn-primary" id="view-forms"> View Created Forms</a>
					</div>
					<div class="col-xs-8 col-md-7">
						<div class="thumbnail">
							{{ HTML::image("img/rfp.png", "Request For Payment") }}
						</div>
					</div>
				</div><!-- .row -->
			</div>
		</div><!-- .row -->
		<br><br>
		<div class="row">
			<div class="col-xs-12 col-md-12" id="form-list">
				<h4 class="text-warning"><i>Related Forms</i></h4>
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#all-forms">All Forms</a></li>
					<li><a href="#requests">Requests</a></li>
					<li><a href="#">Needs Approval</a></li>
				</ul>
				<div class="tab-content">
					<div id="all-forms" class="tab-pane active">
						<div class="table-responsive table-bordered">
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>Form #</th>
										<th>Status</th>
										<th>Created At</th>
										<th>Last Updated At</th>
										<th>Date Requested</th>
										<th>Date Needed</th>
										<th>Payee</th>
										<th>Total Amount</th>
										<th>Particulars</th>
										<th>Client</th>
										<th>Department</th>
										<th>Approved By</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php $counter=0; ?>

								@foreach($forms as $form)
									<tr>
										<td>{{ ++$counter }}</td>
										<td><a href="{{ URL::route('rfps.show', ['form_num' => $formNum = e($form->form_num)]) }}">{{ $formNum }}</a></td>
										<td><button class="btn btn-xs btn-warning">Pending</button></td>
										<td>{{ e($form->created_at) }}</td>
										<td>{{ e($form->updated_at) }}</td>
										<td>{{ e($form->paymentRequest->date_requested) }}</td>
										<td>{{ e($form->paymentRequest->date_needed) }}</td>
										<td>{{ e($form->paymentRequest->payee_full_name) }}</td>
										<td>{{ e($form->paymentRequest->total_amount_formatted) }}</td>
										<td>{{ e($form->paymentRequest->particulars ) }}</td>
										<td>{{ e($form->paymentRequest->client->client_name) }}</td>
										<td>{{ e($form->paymentRequest->department->department_name) }}</td>
										<td>{{ e($form->paymentRequest->approver->first_last_name) }}</td>
									</tr>
								@endforeach
								</tbody>
							</table><!-- .table -->
						</div><!-- .table-responsive -->
					</div><!-- #all-forms -->
					<div id="requests" class="tab-pane">
						<p>Other</p>
					</div>
				</div>
				@if($forms->count())
					{{ $forms->appends(Request::except('page'))->links(); }}
				@endif
			</div><!-- #form-list -->
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop