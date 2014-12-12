@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('list-reject-reasons') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="row table-toolbar">
					<div class="col-lg-4">
						<div class="btn-toolbar" role="toolbar">
							<div class="btn-group btn-group-sm">
								<a href="{{ URL::route('rejectreasons.create') }}" class="btn btn-primary">Add Reason</a>
		  						<a class="btn btn-danger" id="remove-btn" name="remove-btn">Remove Reject Reason</a>
		  						<a class="btn btn-default cancel-btn" id="cancel-btn1" name="cancel-btn1">Cancel Remove</a>
								<button type="button" id="{{ URL::route('rejectreasons.export') }}" class="btn btn-warning export">Export List</button>
							</div><!-- .btn-group -->
						</div><!-- .btn-toolbar -->
					</div>
					<div class="col-lg-5">
						<div class="progress-div" style="display:none;">
							<i class="fa fa-lg fa-cog fa-spin"></i> Exporting the data ...
						</div>
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
						<h4>Active: <small>{{ $active_rejectreasons }}</small></h4>
					</div>
					<div class="col-lg-2">
						<h4>Total: <small>{{ $total_rejectreasons }}</small></h4>
					</div>
					<div class="col-lg-8">
						@if(isset($search) || $search != '')
							<h5>Search:  <mark>{{ $search }}</mark> <a href="{{ URL::route('rejectreasons.index') }}"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a></h5>
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
							    <th>Status</th>
							    <td>{{ sort_rejectreasons_by('form_type', 'Form Type') }}</td>
							    <td>{{ sort_rejectreasons_by('process_type', 'Process') }}</td>
							    <td>{{ sort_rejectreasons_by('updated_at', 'Last Updated At') }}</td>
							    <td>{{ sort_rejectreasons_by('created_at', 'Date Created') }}</td>
							    <td></td>
							  </tr>
							</thead>
							<tbody>
							@foreach($rejectReasons as $rejectReason)
								@if($rejectReason->isDeleted())
									<tr class="danger">
								@else
									<tr>
								@endif
									<td>{{ ++$currentRow }}</a></td>
									<td><a href="{{ URL::route('rejectreasons.edit', e($rejectReason->id)) }}">{{ e($rejectReason->reason) }}</a></td>
									<td>{{ e($rejectReason->status) }}</td>
									<td>{{ e($rejectReason->form_type) }} </td>
									<td>{{ e($rejectReason->process_type) }} </td>
									<td>{{ e($rejectReason->updated_at) }}</td>
									<td>{{ e($rejectReason->created_at) }}</td>
								@if( !($rejectReason->isDeleted()) )
									<td><button class="btn btn-delete" id="{{ e($rejectReason->reason) }}" value="{{ URL::route('rejectreasons.destroy', e($rejectReason->id)) }}" style="display:none;">X</button></td>
								@endif
								</tr>
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

@section('modal-content')
<div class="modal-content">
	{{ Form::open(['id' => 'modal-form', 'route' => ['rejectreasons.destroy'], 'method' => 'DELETE']) }}
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Remove Reject Reason</h4>
		</div>
		<div class="modal-body">
			Are you sure you want to remove reject reason?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default cancel-btn" id="cancel-btn2" data-dismiss="modal">Cancel</button>
			{{ Form::submit('OK', array('class' => 'btn btn-warning')) }}
		</div>
	{{ Form::close() }}
</div><!-- .modal-content -->
@stop