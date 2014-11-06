@extends('layout.inner.master')


@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="row table-toolbar">
					<div class="col-lg-9">
						<div class="btn-toolbar" role="toolbar">
							<div class="btn-group btn-group-sm">
								<a href="{{ URL::route('rejectreasons.create') }}" class="btn btn-primary">Add Reason</a>
								<button type="button" class="btn btn-warning">Export List</button>
							</div><!-- .btn-group -->
						</div><!-- .btn-toolbar -->
					</div>
					<div class="col-lg-3">
						{{ Form::open(['method' => 'GET', 'route' => 'rejectreasons.index']) }}
					      <div class="input-group input-group-sm">
					         {{ Form::input('search', 'q', null, ['class' => 'form-control', 'placeholder' => 'Search']) }}
					          <span class="input-group-btn">
					            <button class="btn btn-default btn-warning" type="submit">Search</button>
					          </span>
					      </div><!-- /input-group -->
					    {{ Form::close() }}
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						<h4>Total Reasons: <small></small></h4>
					</div>
					<div class="col-lg-10">
						@if(isset($search))
							<h4>Search: <mark></mark></h4>
						@endif
					</div>
				</div><!-- .row -->
			</div>
		</div><!-- .row -->
		<div class="row">
			<div class="col-lg-12">
				@if($rejectReasons->count())
			    	<div class="table-responsive">
						<table class="table table-condensed table-hover table-big">
							<thead>
							  <tr>
							    <td>#</td>
							    <td>Date Created</td>
							    <td>Last Updated At</td>
							    <td>Reason</td>
							    <td>Form Type</td>
							    <td></td>
							  </tr>
							</thead>
							<tbody>
							<?php $counter=0; ?>
							@foreach($rejectReasons as $rejectReason)
								<tr>
									<td>{{ ++$counter }}</td>
									<td>{{ e($rejectReason->created_at) }}</td>
									<td>{{ e($rejectReason->updated_at) }}</td>
									<td><a href="{{ URL::route('rejectreasons.edit', e($rejectReason->id)) }}">{{ e($rejectReason->reason) }}</a></td>
									<td>
										<ul>
											@foreach($rejectReason->formRejectReasons as $fRR)
												<li>{{ e($fRR->form_type) }}</li>
											@endforeach
										</ul>
									</td>
									<td></td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div><!-- .table-responsive -->
				@else
			      <h5>No Results found</h5>
			    @endif
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop