@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('edit-client', e($client->client_id)) }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				{{ Form::open(['class' => 'form-horizontal', 'route' => ['clients.update', e($client->id)], 'method' => 'PATCH'])}}
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4>Client Details</h4>
						</div><!-- .panel-heading -->
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="client_id" class="col-sm-4 control-label">ID</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="client_id" name="client_id" value="{{ e($client->client_id) }}">
											@if($errors->has('client_id'))
												<p class="bg-danger">{{ $errors->first('client_id') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="client_name" class="col-sm-4 control-label">Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="client_name" name="client_name" value="{{ e($client->client_name) }}">
											@if($errors->has('client_name'))
												<p class="bg-danger">{{ $errors->first('client_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="address" class="col-sm-4 control-label">Address</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="address" name="address" value="{{ e($client->address) }}">
											@if($errors->has('address'))
												<p class="bg-danger">{{ $errors->first('address') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!-- .row -->
						</div><!-- .panel-body -->
					</div> <!-- .panel -->
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4>Contact Person</h4>
						</div><!-- .panel-heading -->
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="cp_first_name" class="col-sm-4 control-label">First Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="cp_first_name" name="cp_first_name" value="{{ e($client->cp_first_name) }}">
											@if($errors->has('cp_first_name'))
												<p class="bg-danger">{{ $errors->first('cp_first_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="cp_middle_name" class="col-sm-4 control-label">Middle Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="cp_middle_name" name="cp_middle_name" value="{{ e($client->cp_middle_name) }}">
											@if($errors->has('cp_middle_name'))
												<p class="bg-danger">{{ $errors->first('cp_middle_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="cp_last_name" class="col-sm-4 control-label">Last Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="cp_last_name" name="cp_last_name" value="{{ e($client->cp_last_name) }}">
											@if($errors->has('cp_last_name'))
												<p class="bg-danger">{{ $errors->first('cp_last_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!-- .row -->
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="email" class="col-sm-4 control-label">Email</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="email" name="email" value="{{ e($client->email) }}">
											@if($errors->has('email'))
												<p class="bg-danger">{{ $errors->first('email') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="mobile" class="col-sm-4 control-label">Mobile Number</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="mobile" name="mobile" value="{{ e($client->mobile) }}">
											@if($errors->has('mobile'))
												<p class="bg-danger">{{ $errors->first('mobile') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="telephone" class="col-sm-5 control-label">Telephone Number</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" id="telephone" name="telephone" value="{{ e($client->telephone) }}">
											@if($errors->has('telephone'))
												<p class="bg-danger">{{ $errors->first('telephone') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!-- .row -->
						</div><!-- .panel-body -->
					</div> <!-- .panel -->
					<div class="row pull-right">
						<div class="col-lg-12">
							<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Submit</button>
						</div>
					</div><!-- .row -->
			    {{ Form::close() }}
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop