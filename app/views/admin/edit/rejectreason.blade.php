@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('edit-reject-reason', e($rejectReason->id)) }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				{{ Form::open(['class' => 'form-horizontal', 'route' => ['rejectreasons.update', e($rejectReason->id)], 'method' => 'PATCH'])}}
					<div class="panel panel-warning">
						<div class="panel-heading">
							<div class="row">
								<div class="col-lg-10">
									<h4>Details</h4>
								</div>
								<div class="col-lg-2">
									@if( e($rejectReason->isDeleted()) )
										<a href="{{ URL::route('rejectreasons.restore', e($rejectReason->id)) }}" class="btn btn-warning btn-sm pull-right" name="restore-acct-btn" id="restore-acct-btn">Restore Reject Reason</a>
                                    @else
                                    	<button class="btn btn-danger btn-sm pull-right" name="remove-acct-btn" id="remove-acct-btn" data-toggle="modal" data-target="#myModal">Remove Reject Reason</button>
                                    @endif
								</div>
							</div>
						</div><!-- .panel-heading -->
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="onlineForm" class="col-sm-4 control-label">Types of Form</label>
										<div class="col-sm-8">
											<select name="onlineForm" id="onlineForm" class="form-control">
												@foreach($onlineForms as $onlineForm)
													@if(strcasecmp($onlineForm, $rejectReason->form_type) === 0)
														<option value="{{ $onlineForm }}" selected>{{ $onlineForm }}</option>
													@else
														<option value="{{ $onlineForm }}">{{ $onlineForm }}</option>
													@endif
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
												@foreach($processes as $process)
													@if(strcasecmp($process, $rejectReason->process_type) === 0)
														<option value="{{ $process }}" selected>{{ $process }}</option>
													@else
														<option value="{{ $process }}">{{ $process }}</option>
													@endif
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
							<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Submit</button>
						</div>
					</div><!-- .row -->
			    {{ Form::close() }}
			</div>
		</div><!-- .row -->
	</div>
</div><!-- .row -->
@stop

@section('modal-content')
<div class="modal-content">
  {{ Form::open(['id' => 'modal-form', 'route' => ['rejectreasons.destroy', e($rejectReason->id)], 'method' => 'DELETE']) }}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Delete Reject Reason</h4>
    </div>
    <div class="modal-body">
      Are you sure you want to delete this reject reason?
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      {{ Form::submit('OK', array('class' => 'btn btn-warning')) }}
    </div>
  {{ Form::close() }}
</div><!-- .modal-content -->
@stop