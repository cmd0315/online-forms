@extends('layout.inner.master')


@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				{{ Form::open(['class' => 'form-horizontal', 'route' => ['rejectreasons.update', $id = e($rejectReason->id)], 'method' => 'PATCH'])}}
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
											<select class="form-control multiple-select" id="forms" name="forms[]" multiple>
												@foreach($forms as $key => $form)
													@if(in_array($key, $associatedForms))
														<option value="{{$key}}" selected>{{$form}}</option>
													@else
														<option value="{{$key}}">{{$form}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!--.row-->
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="process_type" class="col-sm-4 control-label">Types of Form</label>
										<div class="col-sm-8">
											<select class="form-control" id="process_type" name="process_type">
												@foreach($processes as $key => $process)
													@if(in_array($key, $associatedProcesses))
														<option value="{{$key}}" selected>{{$process}}</option>
													@else
														<option value="{{$key}}">{{$process}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div><!-- .form-group -->
								</div>
							</div><!--.row-->
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="reason" class="col-sm-4 control-label">Reasons</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="reason" name="reason" value="{{ e($rejectReason->reason) }}">
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