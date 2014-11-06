@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('list-departments') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row table-toolbar">
			<div class="col-lg-9">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group btn-group-sm">
						<a href="{{ URL::route('departments.create') }}" class="btn btn-primary">Add Department</a>
						<button type="button" class="btn btn-warning">Export List</button>
  						<button type="button" class="btn btn-danger" id="remove-btn" name="remove-btn">Remove Department</button>
  						<a class="btn btn-default cancel-btn" id="cancel-btn1" name="cancel-btn1">Cancel Remove</a>
					</div><!-- .btn-group -->
				</div><!-- .btn-toolbar -->
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
				<h4>Total Departments: <small>{{ $total_departments }}</small></h4>
			</div>
			<div class="col-lg-10">
				@if(isset($search))
					<h4>Search: <mark>{{ $search }}</mark></h4>
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
							    <td>{{ sort_departments_by('last_name', 'Head Employee') }}</td>
							    <td>{{ sort_departments_by('updated_at', 'Last Updated At') }}</td>
							    <td>{{ sort_departments_by('created_at', 'Date Joined') }}</td>
							    <td></td>
							  </tr>
							</thead>
							<tbody>
							<?php $counter=0; ?>
							@foreach($departments as $department)
							    <tr>
							      <td>{{ ++$counter }}</td>
							      <td><a href="{{ URL::route('departments.show', ['department_id' => $departmentID = e($department->department_id)]) }}">{{ $departmentID }}</a></td>
							      <td> {{ e($department->department_name) }} </td>
							      <td> {{ $department->getDepartmentHead() }} </td>
							      <td> {{ e($department->updated_at) }} </td>
							      <td> {{ e($department->created_at) }} </td>
									@if(($deleteStatus = e($department->deleted_at)) == NULL)
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