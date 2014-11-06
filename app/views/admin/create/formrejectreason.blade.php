@extends('layout.inner.master')


@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				{{ Form::open(array('class' => 'form-horizontal', 'route' => array('rejectreasons.store'))) }}
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4>Reject Reasons</h4>
						</div><!-- .panel-heading -->
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="forms" class="col-sm-4 control-label">Types of Form</label>
										<div class="col-sm-8">
											{{ Form::select('forms[]', $forms, Input::old('forms'), array('multiple', 'class' => 'form-control')) }}
											@if($errors->has('forms'))
												<p class="bg-danger">{{ $errors->first('forms') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!--.row-->
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="reason" class="col-sm-4 control-label">Reasons</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="reason" name="reason"{{ (Input::old('reason')) ? ' value ="' . Input::old('reason') . '"' : '' }}>
											@if($errors->has('reason'))
												<p class="bg-danger">{{ $errors->first('reason') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
									<input type="button" class="btn btn-primary btn-sm pull-right" value="Add More">
								</div>
							</div><!--.row-->
						</div><!-- .panel-body -->
					</div><!-- .panel -->
					<div class="row pull-right">
						<div class="col-lg-12">
							<a href="{{ URL::route('rejectreasons.index') }}" class="btn btn-lg btn-default">View List</a>
							<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Submit</button>
						</div>
					</div><!-- .row -->
			    {{ Form::close() }}
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop