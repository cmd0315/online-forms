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
						<div class="row">
							<div class="col-lg-12">
								<i>
									<h4 class="text-warning">Description</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
								</i>
								<a href="{{ URL::route('rfps.create') }}" class="btn btn-warning"> Make Request</a>
								@if($forms->count())
									<a href="#" class="btn btn-primary" id="view-forms"> View Forms</a>
								@endif
							</div>
						</div><!-- .row -->
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

		@if($currentUser->system_admin)
		<div class="panel panel-warning">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-8">
						<i><h4>Reasons for Rejection</h4></i>
					</div>
					<div class="col-lg-4">
						<div class="btn-group btn-group-sm pull-right">
							<a href="{{ URL::route('rejectreasons.create') }}" class="btn btn-warning btn-sm" id="add-rejection-reasons"> Add More</a>
							<a href="#" class="btn btn-primary btn-sm">Export list</a>
						</div><!-- .btn-group -->
					</div>
				</div><!-- .row -->
			</div><!-- .panel-heading -->
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-condensed table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Reason</th>
										<th>Process</th>
									</tr>
								</thead>
								<tbody>
									<?php $counter=0; ?>
									@foreach($formRejectReasons as $formRejectReason)
										<tr>
											<td>{{ ++$counter }}</td>
											<td>{{ e($formRejectReason->rejectReason->reason) }}</td>
											<td>{{ e($formRejectReason->process_type) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div><!-- .table-responsive -->
					</div>
				</div><!-- .row -->
			</div><!-- .panel-body -->
		</div><!-- .panel -->
		@endif
		<div class="panel panel-warning" id="form-list">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-2">
						<i><h4>Related Forms</h4></i>
					</div>
					<div class="col-lg-5">
					@if(isset($search))
						<h5>Search:  <mark>{{ $search }}</mark> <a href="{{ URL::route('rfps.index') }}"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a></h5>
					@endif
					</div>
					<div class="col-lg-5">
						{{ Form::open(['method' => 'GET', 'class' => 'form-inline', 'route' => 'rfps.index']) }}
							<div class="input-group input-group-sm">
								{{ Form::input('search', 'q', null, ['class' => 'form-control', 'placeholder' => 'Search']) }}
								<span class="input-group-btn">
									<button class="btn btn-default btn-warning" type="submit">Search</button>
									<a href="{{ URL::route('rfps.create') }}" class="btn btn-primary btn-sm"> Make Request</a>
									<a href="{{ URL::route('rfps.export') }}" class="btn btn-info btn-sm">Export list</a>
								</span>
						    </div><!-- /input-group -->
					    {{ Form::close() }}
					</div>
				</div><!-- .row -->
			</div><!-- .panel-heading -->
			<div class="panel-body">
				<div class="row">			
					<div class="col-xs-12 col-md-12">
						<ul class="nav nav-tabs" role="tablist">
							<li class="active"><a href="#all-forms" role="tab" data-toggle="tab">All Forms</a></li>
							<li class=""><a href="#requested-forms" role="tab" data-toggle="tab">Profile</a></li>
						</ul><!-- .nav-tabs -->
						<div class="tab-content">
							<div class="tab-pane fade active in" id="all-forms">
								@if($forms->count())
									<div class="table-responsive">
										<table class="table table-condensed table-hover table-big">
											<thead>
												<tr>
													<th></th>
													<th>Form #</th>
													<th>{{ sort_rfps_by('status', 'Status') }}</th>
													<th>{{ sort_rfps_by('created_by', 'Created By') }}</th>
													<th>{{ sort_rfps_by('created_at', 'Created At') }}</th>
													<th>{{ sort_rfps_by('updated_by', 'Last Updated By') }}</th>
													<th>{{ sort_rfps_by('updated_at', 'Last Updated At') }}</th>
													<th>{{ sort_rfps_by('date_requested', 'Date Requested') }}</th>
													<th>{{ sort_rfps_by('date_needed', 'Date Needed') }}</th>
													<th>{{ sort_rfps_by('payee_lastname', 'Payee') }}</th>
													<th>{{ sort_rfps_by('total_amount', 'Total Amount') }}</th>
													<th>Particulars</th>
													<th>{{ sort_rfps_by('client_name', 'Client') }}</th>
													<th>{{ sort_rfps_by('department_name', 'Department') }}</th>
													<th>{{ sort_rfps_by('approved_by', 'Approved By') }}</th>
													<th>{{ sort_rfps_by('received_by', 'Received By') }}</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
											<?php $counter=0; ?>

											@foreach($forms as $form)
												<tr>
													<td>{{ ++$counter }}</td>
													<td><a href="{{ URL::route('rfps.show', ['form_num' => $formNum = e($form->form_num)]) }}">{{ $formNum }}</a></td>
													<td>{{ e($form->onlineForm->request_status_formatted) }}</td>
													<td>{{ e($form->onlineForm->created_by_formatted) }}</td>
													<td>{{ e($form->onlineForm->created_at) }}</td>
													<td>{{ e($form->onlineForm->updated_by_formatted) }}</td>
													<td>{{ e($form->onlineForm->updated_at) }}</td>
													<td>{{ e($form->date_requested) }}</td>
													<td>{{ e($form->date_needed) }}</td>
													<td>{{ e($form->payee_full_name) }}</td>
													<td>{{ e($form->total_amount_formatted) }}</td>
													<td>{{ e($form->particulars) }}</td>
													<td>{{ e($form->client_formatted) }}</td>
													<td>{{ e($form->onlineForm->department_formatted) }}</td>
													<td>{{ e($form->onlineForm->approved_by_formatted) }}</td>
													<td>{{ e($form->onlineForm->received_by_formatted) }}</td>
												</tr>
											@endforeach
											</tbody>
										</table><!-- .table -->
										{{ $forms->appends(Request::except('page'))->links(); }}
									</div><!-- .table-responsive -->
							    @else
							      <h5>No Results found</h5>
							    @endif
							</div><!-- .tab-pane -->
							<div class="tab-pane fade" id="requested-forms">
								<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
							</div><!-- .tab-pane -->
						</div><!-- .tab-content -->
					</div><!-- #form-list -->
				</div><!-- .row -->
			</div><!-- .panel-body -->
		</div><!-- .panel -->
	</div>
</div><!-- .row -->
@stop