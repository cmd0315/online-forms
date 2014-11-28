@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('list-departments') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row table-toolbar">
			<div class="col-lg-4">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group btn-group-sm">
						<a href="{{ URL::route('departments.create') }}" class="btn btn-primary">Add Department</a>
						<button type="button" id="{{ URL::route('departments.export') }}" class="btn btn-warning export">Export List</button>
  						<button type="button" class="btn btn-danger" id="remove-btn" name="remove-btn">Remove Department</button>
  						<a class="btn btn-default cancel-btn" id="cancel-btn1" name="cancel-btn1">Cancel Remove</a>
					</div><!-- .btn-group -->
				</div><!-- .btn-toolbar -->
			</div>
			<div class="col-lg-5">
				<div class="progress-div" style="display:none;">
					<i class="fa fa-lg fa-cog fa-spin"></i> Exporting the data ...
				</div>
			</div>
			<div class="col-lg-3">
				{{ Form::open(['method' => 'GET', 'route' => 'departments.index']) }}
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
				<h4>Active: <small>{{ $active_departments }}</small></h4>
			</div>
			<div class="col-lg-2">
				<h4>Total: <small>{{ $total_departments }}</small></h4>
			</div>
			<div class="col-lg-8">
				@if(isset($search))
					<h5>Search:  <mark>{{ $search }}</mark> <a href="{{ URL::route('departments.index') }}"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a></h5>
				@endif
			</div>
		</div><!-- .row -->
		<div class="row">
			<div class="col-lg-12">
			    @if($departments->count())
			    	<div class="table-responsive">
						<table class="table table-condensed table-hover table-big" id="employee-table">
							<thead>
							  <tr>
							    <td>#</td>
							    <td>{{ sort_departments_by('department_id', 'ID') }}</td>
							    <td>{{ sort_departments_by('department_name', 'Name') }}</td>
							    <td>Status</td>
							    <td>{{ sort_departments_by('last_name', 'Head Employee') }}</td>
							    <td>{{ sort_departments_by('updated_at', 'Last Updated At') }}</td>
							    <td>{{ sort_departments_by('created_at', 'Date Joined') }}</td>
							    <td></td>
							  </tr>
							</thead>
							<tbody>
							@foreach($departments as $department)
								@if($department->isDeleted())
							    	<tr class="danger">
							    @else
							    	<tr>
							    @endif
								      <td>{{ ++$currentRow }}</td>
								      <td><a href="{{ URL::route('departments.show', ['department_id' => $departmentID = e($department->department_id)]) }}">{{ $departmentID }}</a></td>
								      <td> {{ e($department->department_name) }} </td>
								      <td> {{ e($department->department_status) }} </td>
								      <td> {{ $department->department_head }} </td>
								      <td> {{ e($department->updated_at) }} </td>
								      <td> {{ e($department->created_at) }} </td>
									@if( !($department->isDeleted()) )
										<td><button class="btn btn-delete" id="{{ e($department->department_name) }}" value="{{ URL::route('departments.destroy', e($department->department_id)) }}" style="display:none;">X</button></td>
									@endif
							    </tr>
							@endforeach
							</tbody>
						</table>
					</div><!-- .table-responsive -->
					{{ $departments->appends(Request::except('page'))->links(); }}
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
	{{ Form::open(['id' => 'modal-form', 'route' => ['employees.destroy'], 'method' => 'DELETE']) }}
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Remove Department</h4>
		</div>
		<div class="modal-body">
			Are you sure you want to remove <span id="subject-name"></span> department?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default cancel-btn" id="cancel-btn2" data-dismiss="modal">Cancel</button>
			{{ Form::submit('OK', array('class' => 'btn btn-warning')) }}
		</div>
	{{ Form::close() }}
</div><!-- .modal-content -->
@stop