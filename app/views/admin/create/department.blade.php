@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('add-department') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				{{ Form::open(array('class' => 'form-horizontal', 'route' => array('departments.store'))) }}
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4>Department Details</h4>
						</div><!-- .panel-heading -->
						<div class="panel-body">
							<div class="row">
					        	<div class="col-lg-12">
									<div class="form-group">
										<label for="department_id" class="col-sm-4 control-label">ID</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="department_id" name="department_id" readonly>
											@if($errors->has('department_id'))
												<p class="bg-danger">{{ $errors->first('department_id') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
										<label for="department_name" class="col-sm-4 control-label">Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="department_name" name="department_name">
											@if($errors->has('department_name'))
												<p class="bg-danger">{{ $errors->first('department_name') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<div class="form-group">
										<label for="date_added" class="col-sm-4 control-label">Date Added</label>
										<div class="col-sm-8">
											<input type="date" class="form-control" id="date_added" name="date_added" value="{{ date('Y-m-d') }}" readonly>
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!-- .row -->
							<div class="row pull-right">
								<div class="col-lg-12">
									<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Submit</button>
								</div>
							</div><!-- .row -->
						</div><!-- .panel-body -->
					</div> <!-- .panel -->
					{{ Form::token() }}
			    {{ Form::close() }}
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop