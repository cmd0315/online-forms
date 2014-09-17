@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('list-employees') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row table-toolbar">
			<div class="col-lg-9">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group btn-group-sm">
						<a href="{{ URL::route('employees.create') }}" class="btn btn-primary">Add Employee</a>
						<button type="button" class="btn btn-warning">Export List</button>
  						<button type="button" class="btn btn-danger">Remove Employee</button>
					</div>
					<div class="btn-group btn-group-sm">
						<div class="form-group">
							<label for="filter-option" class="col-sm-5 control-label">Filter by:</label>
							<div class="col-sm-7">
								<select name="filter-option" id="filter-option">
									<option value="surname">Surname</option>
									<option value="age">Age</option>
									<option value="status">Status</option>
									<option value="department">Department</option>
									<option value="position">Position</option>
								</select>
							</div>
						</div><!-- .form-group -->

					</div>
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
			    @if($employees->count())
			    	<div class="table-responsive">
						<table class="table table-condensed table-hover table-big" id="employee-table">
							<thead>
							  <tr>
							    <td>#</td>
							    <td>Name</td>
							    <td>Username</td>
							    <td>Status</td>
							    <td>Birthdate</td>
							    <td>Address</td>
							    <td>Department</td>
							    <td>Position</td>
							    <td>Email</td>
							    <td>Mobile</td>
							    <td>Last Updated At</td>
							    <td>Date Joined</td>
							    <td></td>
							  </tr>
							</thead>
							<tbody>
							<?php $counter=0; ?>
							@foreach($employees as $employee)
							  @if(($status = e($employee->account->status)) > 0)
							    <tr class="danger">
							  @else
							    <tr>
							  @endif
							      <td>{{ ++$counter }}</td>
							      <?php $username = e($employee->username); ?>
							      <td> <a href="{{ URL::route('employees.show', ['username' => $username]) }}">{{ e($employee->first_name) . " " . e($employee->middle_name) . " " . e($employee->last_name) }} </a></td>
							      <td> {{ $username }} </td>
							      <td> {{e($employee->account->status)}} </td>
							      <td> {{ e($employee->birthdate) }} </td>
							      <td> {{ e($employee->address) }}</td>
							      <td> {{ e($employee->department->department_name) }} </td>
							      <td> {{ e($employee->position_title) }} </td>
							      <td> {{ e($employee->email) }} </td>
							      <td> {{ e($employee->mobile) }} </td>
							      <td> {{ e($employee->account->updated_at) }} </td>
							      <td> {{ e($employee->account->created_at) }} </td>
							    </tr>
							@endforeach
							</tbody>
						</table>
					</div><!-- .table-responsive -->
					{{ $employees->appends(Request::except('page'))->links(); }}
			    @else
			      <h5>No Results found</h5>
			    @endif
			</div>
		</div>
	</div>
</div><!-- .row -->
@stop