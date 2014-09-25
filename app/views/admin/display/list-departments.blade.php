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
  						<button type="button" class="btn btn-danger">Remove Department</button>
					</div>
					<div class="btn-group btn-group-sm">
						<div class="form-group">
							<label for="filter-option" class="col-sm-5 control-label">Filter by:</label>
							<div class="col-sm-7">
								<select name="filter-option" id="filter-option">
									<option value="name">Name</option>
									<option value="date_added">Date Added</option>
								</select>
							</div>
						</div><!-- .form-group -->
					</div><!-- .btn-group -->
				</div><!-- .btn-toolbar -->
			</div>
			<div class="col-lg-3">
				<div class="input-group input-group-sm">
					<input type="text" class="form-control">
					<span class="input-group-btn">
						<button class="btn btn-warning" type="button">Search</button>
					</span>
				</div><!-- /input-group -->
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
			    @if($departments->count())
			    	<div class="table-responsive">
						<table class="table table-condensed table-hover table-big" id="employee-table">
							<thead>
							  <tr>
							    <td>#</td>
							    <td>Department ID</td>
							    <td>Name</td>
							    <td>Head Employee</td>
							    <td>Last Updated At</td>
							    <td>Date Joined</td>
							    <td></td>
							  </tr>
							</thead>
							<tbody>
							<?php $counter=0; ?>
							@foreach($departments as $department)
							    <tr>
							      <td>{{ ++$counter }}</td>
							      <td>{{ $departmentID = e($department->department_id) }}</td>
							      <td> <a href="{{ URL::route('departments.show', ['department_id' => $departmentID]) }}">{{ e($department->department_name) }} </a></td>
							      <td> {{ $department->getDepartmentHead() }} </td>
							      <td> {{ e($department->updated_at) }} </td>
							      <td> {{ e($department->created_at) }} </td>
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
		</div>
	</div>
</div><!-- .row -->
@stop