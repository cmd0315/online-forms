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
								<a href="{{ URL::route('rejectreasons.export') }}" class="btn btn-warning">Export List</a>
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
						<h4>Total Reasons: <small>{{$total_rejectreasons}}</small></h4>
					</div>
					<div class="col-lg-10">
						@if(isset($search) || $search != '')
							<h4>Search: <mark>{{ $search }}</mark></h4>
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
							    <td>{{ sort_rejectreasons_by('reason', 'Reason') }}</td>
							    <td>{{ sort_rejectreasons_by('form_type', 'Form Type') }}</td>
							    <td>{{ sort_rejectreasons_by('process_type', 'Process') }}</td>
							    <td>{{ sort_rejectreasons_by('updated_at', 'Last Updated At') }}</td>
							    <td>{{ sort_rejectreasons_by('created_at', 'Date Created') }}</td>
							    <td></td>
							  </tr>
							</thead>
							<tbody>
							<?php $counter=0; ?>
							@foreach($rejectReasons as $rejectReason)
								@foreach($rejectReason->formRejectReasons as $fRR)
									<tr>
										<td><a href="{{ URL::route('rejectreasons.edit', e($fRR->id)) }}">{{ ++$counter }}</a></td>
										<td>{{ e($rejectReason->reason) }}</td>
										<td>{{ e($fRR->form_type) }} </td>
										<td>{{ e($fRR->process) }} </td>
										<td>{{ e($rejectReason->updated_at) }}</td>
										<td>{{ e($rejectReason->created_at) }}</td>
										<td></td>
									</tr>
								@endforeach
							@endforeach
							</tbody>
						</table>
					</div><!-- .table-responsive -->
					{{ $rejectReasons->appends(Request::except('page'))->links(); }}
				@else
			      <h5>No Results found</h5>
			    @endif
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop