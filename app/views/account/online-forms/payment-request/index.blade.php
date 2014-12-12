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
								<a href="{{ URL::route('prs.create') }}" class="btn btn-warning"> Make Request</a>
								
								<a href="#" class="btn btn-primary" id="view-forms"> View Forms</a>
							</div>
						</div><!-- .row -->
					</div>
					<div class="col-xs-8 col-md-7">
						<div class="thumbnail">
							{{ HTML::image("img/payment-request.png", "Payment Request Form") }}
						</div>
					</div>
				</div><!-- .row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-warning" id="form-list">
							<div class="panel-heading">
								<div class="row">
									<div class="col-lg-2">
										<i><h4>Related Forms</h4></i>
									</div>
									<div class="col-lg-3">
									@if(isset($search))
										<h5>Search:  <mark class="searchQuery">{{ $search }}</mark> <a href="{{ action('PaymentRequestsController@index', ['q' => '']) }}"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a></h5>
									@endif
									</div>
									<div class="col-lg-2">
										<div class="progress-div" style="display:none;">
											<i class="fa fa-lg fa-cog fa-spin"></i> Exporting the data ...
										</div>
									</div>
									<div class="col-lg-5">
										{{ Form::open(['method' => 'GET', 'class' => 'form-inline', 'route' => 'prs.index']) }}
											<div class="input-group input-group-sm">
												{{ Form::input('search', 'q', null, ['class' => 'form-control', 'placeholder' => 'Search']) }}
												<span class="input-group-btn">
													<button class="btn btn-default btn-warning" type="submit">Search</button>
													<a href="{{ URL::route('prs.create') }}" class="btn btn-primary btn-sm"> Make Request</a>
												</span>
										    </div><!-- /input-group -->
									    {{ Form::close() }}
									</div>
								</div><!-- .row -->
							</div><!-- .panel-heading -->
							<div class="panel-body">
								<div class="row">			
									<div class="col-xs-12 col-md-12">
										@if($paymentRequests->count())
											<div class="table-responsive">
												<table class="table table-condensed table-hover table-big">
													<thead>
														<tr>
															<th></th>
															<th>Form #</th>
															<th>{{ sort_prs_by('created_by', 'Created By') }}</th>
															<th>{{ sort_prs_by('created_at', 'Created At') }}</th>
															<th>{{ sort_prs_by('updated_by', 'Last Updated By') }}</th>
															<th>{{ sort_prs_by('updated_at', 'Last Updated At') }}</th>
															<th>{{ sort_prs_by('date_requested', 'Date Requested') }}</th>
															<th>{{ sort_prs_by('date_needed', 'Date Needed') }}</th>
															<th>{{ sort_prs_by('payee_lastname', 'Payee') }}</th>
															<th>{{ sort_prs_by('total_amount', 'Total Amount') }}</th>
															<th>Particulars</th>
															<th>{{ sort_prs_by('client_name', 'Client') }}</th>
															<th>{{ sort_prs_by('department_name', 'Department') }}</th>
															<th>{{ sort_prs_by('approved_by', 'Approved By') }}</th>
															<th>{{ sort_prs_by('received_by', 'Received By') }}</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
													@foreach($paymentRequests as $paymentRequest)
														<tr>
															<td>{{ ++$currentRow }}</td>
															<td><a href="{{ URL::route('prs.show', ['form_num' => $formNum = e($paymentRequest->form_num)]) }}">{{ $formNum }}</a></td>
															<td>{{ e($paymentRequest->onlineForm->creator->profile_link) }}</td>
															<td>{{ e($paymentRequest->onlineForm->created_at) }}</td>
															<td>{{ e($paymentRequest->onlineForm->updator->profile_link) }}</td>
															<td>{{ e($paymentRequest->onlineForm->updated_at) }}</td>
															<td>{{ e($paymentRequest->date_requested) }}</td>
															<td>{{ e($paymentRequest->date_needed) }}</td>
															<td>{{ e($paymentRequest->payee_full_name) }}</td>
															<td>{{ e($paymentRequest->total_amount) }}</td>
															<td>{{ e($paymentRequest->particulars) }}</td>
															<td>{{ e($paymentRequest->client->profile_link) }}</td>
															<td>{{ e($paymentRequest->onlineForm->department->profile_link) }}</td>
															<td>{{ e($paymentRequest->onlineForm->approved_by_with_link) }}</td>
															<td>{{ e($paymentRequest->onlineForm->received_by_with_link) }}</td>
														</tr>
													@endforeach
													</tbody>
												</table><!-- .table -->
												{{ $paymentRequests->appends(Request::except('page'))->links(); }}
											</div><!-- .table-responsive -->
									    @else
									      <h5>No Results found</h5>
									    @endif
									</div>
								</div><!-- .row -->
							</div><!-- .panel-body -->
						</div><!-- .panel -->
					</div>
				</div><!-- .row -->
			</div>
		</div><!-- .row -->
		<br><br>
	</div>
</div><!-- .row -->
@stop