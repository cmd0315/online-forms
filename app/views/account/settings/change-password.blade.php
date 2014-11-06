@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('change-password', e($currentUser->username)) }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-9 col-lg-offset-1">
		<div class="row">
			<div class="col-lg-4">
				@include('layout.inner.settings._navigation')
			</div>
			<div class="col-lg-7 col-lg-offset-1">
				{{ Form::open(['class' => 'form-horizontal', 'route' => ['accounts.update', e($currentUser->username)], 'method' => 'PATCH']) }}
					<div class="row">
						<h4>Account Details</h4>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="old_password" class="col-sm-3 control-label">Old Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="old_password" name="old_password">
									@if($errors->has('old_password'))
										<p class="bg-danger">{{ $errors->first('old_password') }}</p>
									@endif
								</div>
							</div><!-- .form-group -->
						<div class="form-group">
							<label for="password" class="col-sm-3 control-label">New Password</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password" name="password">
								@if($errors->has('password'))
									<p class="bg-danger">{{ $errors->first('password') }}</p>
								@endif
							</div>
						</div><!-- .form-group -->
						<div class="form-group">
						<label for="password_again" class="col-sm-3 control-label">Retype New Password</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password_again" name="password_again">
								@if($errors->has('password_again'))
									<p class="bg-danger">{{ $errors->first('password_again') }}</p>
								@endif
							</div>
						</div><!-- .form-group -->
					</div>
				</div><!-- .row -->
				<div class="row pull-right">
					<div class="col-lg-12">
						<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Submit</button>
					</div>
				</div><!-- /row -->
			</div>
		{{ Form::close() }}
	</div>
</div><!-- .row -->
@stop

@section('sub-heading')
   {{$currentUser->username}}
@stop