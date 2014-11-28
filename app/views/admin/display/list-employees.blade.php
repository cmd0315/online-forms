@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('list-employees') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row table-toolbar">
			<div class="col-lg-4">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group btn-group-sm">
						<a href="{{ URL::route('employees.create') }}" class="btn btn-primary">Add Employee</a>
						<button type="button" id="{{ URL::route('employees.export') }}" class="btn btn-warning export">Export List</button>
  						<a class="btn btn-danger" id="remove-btn" name="remove-btn">Remove Employee</a>
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
				{{ Form::open(['method' => 'GET', 'route' => 'employees.index']) }}
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
				<h4>Active: <small>{{ $active_employees }}</small></h4>
			</div>
			<div class="col-lg-2">
				<h4>Total: <small>{{ $total_employees }}</small></h4>
			</div>
			<div class="col-lg-8">
				@if(isset($search))
					<h5>Search:  <mark>{{ $search }}</mark> <a href="{{ URL::route('employees.index') }}"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a></h5>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
			    @if($employees->count())
			    	<div class="table-responsive">
						<table class="table table-condensed table-hover table-big">
							<thead>
							  <tr>
							    <th>#</th>
							    <th>{{ sort_employees_by('username', 'Username') }}</th>
							    <th>Status</th>
							    <th>{{ sort_employees_by('last_name', 'Name') }}</th>
							    <th>{{ sort_employees_by('birthdate', 'Birthdate') }}</th>
							    <th>{{ sort_employees_by('address', 'Address') }}</th>
							    <th>{{ sort_employees_by('department_id', 'Department') }}</th>
							    <th>{{ sort_employees_by('position', 'Position') }}</th>
							    <th>{{ sort_employees_by('email', 'Email') }}</th>
							    <th>Mobile</th>
							    <th>{{ sort_employees_by('updated_at', 'Last Updated At') }}</th>
							    <th>{{ sort_employees_by('created_at', 'Date Registered') }}</th>
							    <th></th>
							  </tr>
							</thead>
							<tbody>
							@foreach($employees as $employee)
							  @if($employee->isDeleted())
							    <tr class="danger">
							  @else
							    <tr>
							  @endif
									<td>{{ ++$currentRow }}</td>
									<td> <a href="{{ URL::route('employees.show', ['username' => $username = e($employee->username)]) }}">{{ $username }} </a></td>
									<td> {{ e($employee->employeeStatus) }}</td>
									<td> {{ e($employee->first_name) . " " . e($employee->middle_name) . " " . e($employee->last_name) }}</td>
									<td> {{ e($employee->birthdate) }} </td>
									<td> {{ e($employee->address) }}</td>
									<td> {{ e($employee->department->department_name) }} </td>
									<td> {{ e($employee->position_title) }} </td>
									<td> {{ e($employee->email) }} </td>
									<td> {{ e($employee->mobile) }} </td>
									<td> {{ e($employee->account->updated_at) }} </td>
									<td> {{ e($employee->account->created_at) }} </td>
								@if( !($employee->isDeleted()) )
									<td><button class="btn btn-delete" id="{{ e($employee->full_name) }}" value="{{ URL::route('employees.destroy', e($employee->username)) }}" style="display:none;">X</button></td>
								@endif
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

@section('modal-content')
<div class="modal-content">
	{{ Form::open(['id' => 'modal-form', 'route' => ['employees.destroy'], 'method' => 'DELETE']) }}
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Deactivate Employee Account</h4>
		</div>
		<div class="modal-body">
			Are you sure you want to deactivate <span id="subject-name">employee</span>'s account?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default cancel-btn" id="cancel-btn2" data-dismiss="modal">Cancel</button>
			{{ Form::submit('OK', array('class' => 'btn btn-warning')) }}
		</div>
	{{ Form::close() }}
</div><!-- .modal-content -->
@stop