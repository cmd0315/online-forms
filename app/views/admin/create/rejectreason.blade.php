@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('add-reject-reason') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				{{ Form::open(array('class' => 'form-horizontal', 'route' => array('rejectreasons.store'))) }}
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4>Details</h4>
						</div><!-- .panel-heading -->
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="onlineForm" class="col-sm-4 control-label">Types of Form</label>
										<div class="col-sm-8">
											<select name="onlineForm" id="onlineForm" class="form-control">
												<option value=""></option>
												@foreach($onlineForms as $onlineForm)
													<option value="{{ $onlineForm }}">{{ $onlineForm }}</option>
												@endforeach
											</select>
											@if($errors->has('onlineForm'))
												<p class="bg-danger">{{ $errors->first('onlineForm') }}</p>
											@endif
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!--.row-->
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="processType" class="col-sm-4 control-label">Use For</label>
										<div class="col-sm-8">
											<select name="processType" id="processType" class="form-control">
												<option value=""></option>
												@foreach($processes as $process)
													<option value="{{ $process }}">{{ $process }}</option>
												@endforeach
											</select>
											@if($errors->has('processType'))
												<p class="bg-danger">{{ $errors->first('processType') }}</p>
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
								</div>
							</div><!--.row-->
						</div><!-- .panel-body -->
					</div><!-- .panel -->
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