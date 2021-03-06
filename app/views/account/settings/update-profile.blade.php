@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('update-profile', e($employee->username)) }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="row">
			<div class="col-lg-4">
				@include('layout.inner.settings._navigation')
			</div>
			<div class="col-lg-7 col-lg-offset-1">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h4>Employee Information</h4>
					</div>
					<div class="panel-body">
						{{ Form::open(['class' => 'form-horizontal', 'route' => ['profile.update', $username = $employee->username], 'method' => 'PATCH']) }}
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="first_name" class="col-sm-4 control-label">First Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="first_name" name="first_name" value="{{ e($employee->first_name) }}">
											@if($errors->has('first_name'))
												<p class="bg-danger">{{ $errors->first('first_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
									<label for="middle_name" class="col-sm-4 control-label">Middle Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ e($employee->middle_name) }}">
											@if($errors->has('middle_name'))
												<p class="bg-danger">{{ $errors->first('middle_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
										<label for="last_name" class="col-sm-4 control-label">Last Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="last_name" name="last_name" value="{{ e($employee->last_name) }}">
											@if($errors->has('last_name'))
												<p class="bg-danger">{{ $errors->first('last_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
									<label for="mobile" class="col-sm-4 control-label">Birthdate</label>
										<div class="col-sm-8">
											<input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ e($employee->birthdate) }}">
											@if($errors->has('birthdate'))
												<p class="bg-danger">{{ $errors->first('birthdate') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
										<label for="address" class="col-sm-4 control-label">Address</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="address" name="address" value="{{ e($employee->address) }}">
											@if($errors->has('address'))
												<p class="bg-danger">{{ $errors->first('address') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
										<label for="mobile" class="col-sm-4 control-label">Mobile Number</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="mobile" name="mobile" value="{{ e($employee->mobile) }}">
											@if($errors->has('mobile'))
												<p class="bg-danger">{{ $errors->first('mobile') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
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
											<p class="form-control-static">{{ e($employee->department->department_name) }}</p>
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
										<label for="position" class="col-sm-4 control-label">Positon</label>
										<div class="col-sm-8">
											<p class="form-control-static">{{ e($employee->position_title) }}</p>
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!-- .row -->
							<div class="row pull-right">
								<div class="col-lg-12">
									<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Save</button>
								</div>
							</div><!-- .row -->	
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop

@section('sub-heading')
   {{$employee->username}}
@stop