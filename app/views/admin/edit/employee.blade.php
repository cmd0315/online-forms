@extends('layout.inner.master')

@section('breadcrumbs')
	{{ Breadcrumbs::render('edit-employee', e($employee->username)) }}
@stop

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					{{ Form::open(['class' => 'form-horizontal', 'route' => ['employees.update', $username = e($employee->username)], 'method' => 'PATCH'])}}
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4>Employee Information</h4>
						</div><!-- .panel-heading -->
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="first_name" class="col-sm-4 control-label">First Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="first_name" name="first_name" value="{{ e($employee->first_name) }}">
											@if($errors->has('first_name'))
												<p class="bg-danger">{{ $errors->first('first_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="middle_name" class="col-sm-4 control-label">Middle Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ e($employee->middle_name) }}">
											@if($errors->has('middle_name'))
												<p class="bg-danger">{{ $errors->first('middle_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="last_name" class="col-sm-4 control-label">Last Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="last_name" name="last_name" value="{{ e($employee->last_name) }}">
											@if($errors->has('last_name'))
												<p class="bg-danger">{{ $errors->first('last_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!-- .row -->
							<div class="row">
								<div class="col-lg-5">
									<div class="form-group">
										<label for="mobile" class="col-sm-4 control-label">Birthdate</label>
										<div class="col-sm-8">
											<input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ e($employee->birthdate) }}">
											@if($errors->has('birthdate'))
												<p class="bg-danger">{{ $errors->first('birthdate') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-7">
									<div class="form-group">
										<label for="address" class="col-sm-4 control-label">Address</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="address" name="address" value="{{ e($employee->address) }}">
											@if($errors->has('address'))
												<p class="bg-danger">{{ $errors->first('address') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!-- .row -->
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="email" class="col-sm-4 control-label">Email Address</label>
										<div class="col-sm-8">
											<input type="email" class="form-control" id="email" name="email" value="{{ e($employee->email) }}">
											@if($errors->has('email'))
												<p class="bg-danger">{{ $errors->first('email') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
										<label for="position" class="col-sm-4 control-label">Department</label>
										<div class="col-sm-8">
											<select class="form-control" id="department" name="department">
												@foreach($departments as $department)
													@if(e($department->department_id) == e($employee->department_id))
													<option value="{{ e($department->department_id) }}" selected="selected">{{ e($department->department_name) }}</option>
													@else
													<option value="{{ e($department->department_id) }}">{{ e($department->department_name) }}</option>
													@endif
												@endforeach
											</select>
											@if($errors->has('department'))
												<p class="bg-danger">{{ $errors->first('department') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="mobile" class="col-sm-4 control-label">Mobile Number</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="mobile" name="mobile" value="{{ e($employee->mobile) }}">
											@if($errors->has('mobile'))
												<p class="bg-danger">{{ $errors->first('mobile') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!-- .row -->
						</div><!-- .panel-body -->
					</div><!-- .panel -->
					<div class="row pull-right">
						<div class="col-lg-12">
							<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Save</button>
						</div>
					</div><!-- .row -->
					{{ Form::token() }}
				{{ Form::close() }}
				</div>
			</div><!-- .row -->
		</div>
	</div><!-- row -->
@stop

@section('sub-heading')
   {{$username}}
@stop
