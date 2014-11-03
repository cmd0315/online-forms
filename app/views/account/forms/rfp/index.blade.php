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
						<br>
						<div class="row">
							<div class="col-lg-12">
								@if($currentUser->system_admin)
									<i><h4 class="text-warning">Reasons for Rejection</h4></i>
									<ol>
										<li>Incomplete attachments</li>
										<li>Not enogh funds</li>
									</ol>
									<a href="#" class="btn btn-warning btn-sm pull-right" id="add-rejection-reasons"> Add More</a>
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
		@if($forms->count())
			<div class="row">
				<div class="col-xs-12 col-md-8" id="form-list">
					<h4 class="text-warning"><i>Related Forms</i></h4>
				</div>
				<div class="col-xs-12 col-md-4">
					{{ Form::open(['method' => 'GET', 'route' => 'rfps.index']) }}
				      <div class="input-group input-group-sm">
				         {{ Form::input('search', 'q', null, ['class' => 'form-control', 'placeholder' => 'Search']) }}
				          <span class="input-group-btn">
				            <button class="btn btn-default btn-warning" type="submit">Search</button>
				          </span>
				      </div><!-- /input-group -->
				    {{ Form::close() }}
				</div>
			</div><!-- .row -->
			<div class="row">			
				<div class="col-xs-12 col-md-12">
					<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#all-forms" role="tab" data-toggle="tab">All Forms</a></li>
						<li class=""><a href="#requested-forms" role="tab" data-toggle="tab">Profile</a></li>
					</ul><!-- .nav-tabs -->
					<div class="tab-content">
						<div class="tab-pane fade active in" id="all-forms">
							<div class="table table-condensed table-hover table-big">
								<table class="table">
									<thead>
										<tr>
											<th></th>
											<th>Form #</th>
											<th>Status</th>
											<th>Created By</th>
											<th>Created At</th>
											<th>Last Updated By</th>
											<th>Last Updated At</th>
											<th>Date Requested</th>
											<th>Date Needed</th>
											<th>Payee</th>
											<th>Total Amount</th>
											<th>Particulars</th>
											<th>Client</th>
											<th>Department</th>
											<th>Approved By</th>
											<th>Received By</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									<?php $counter=0; ?>

									@foreach($forms as $form)
										<tr>
											<td>{{ ++$counter }}</td>
											<td><a href="{{ URL::route('rfps.show', ['form_num' => $formNum = e($form->form_num)]) }}">{{ $formNum }}</a></td>
											<td>{{ e($form->onlineForm->request_status) }}</td>
											<td>{{ e($form->onlineForm->created_by_formatted) }}</td>
											<td>{{ e($form->onlineForm->created_at) }}</td>
											<td>{{ e($form->onlineForm->updated_by_formatted) }}</td>
											<td>{{ e($form->onlineForm->updated_at) }}</td>
											<td>{{ e($form->date_requested) }}</td>
											<td>{{ e($form->date_needed) }}</td>
											<td>{{ e($form->payee_full_name) }}</td>
											<td>{{ e($form->total_amount) }}</td>
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
						</div><!-- .tab-pane -->
						<div class="tab-pane fade" id="requested-forms">
							<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
						</div><!-- .tab-pane -->
					</div><!-- .tab-content -->
				</div><!-- #form-list -->
			</div><!-- .row -->
		@endif
	</div>
</div><!-- .row -->
@stop