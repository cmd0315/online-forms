@extends('layout.inner.master')


@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4>Employee Information</h4>
						</div>
						<div class="panel-body">
							{{ Form::open(['class' => 'form-horizontal', 'route' => ['departments.update', e($department->id)], 'method' => 'PATCH'])}}
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="department_id" class="col-sm-4 control-label">ID</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="department_id" name="department_id" value="{{ e($department->department_id) }}">
												@if($errors->has('department_id'))
													<p class="bg-danger">{{ $errors->first('department_id') }}</p>
												@endif
											</div>
										</div><!-- .form-group -->
										<div class="form-group">
											<label for="department_name" class="col-sm-4 control-label">Name</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="department_name" name="department_name" value="{{ e($department->department_name) }}">
												@if($errors->has('department'))
													<p class="bg-danger">{{ $errors->first('department') }}</p>
												@endif
											</div>
										</div><!-- .form-group -->
										<div class="form-group">
											<label for="department_head" class="col-sm-4 control-label">Head Employee</label>
											<div class="col-sm-8">
												<select class="form-control" name="department_head" id="department_head">
													@foreach($members as $member)
														@if($member->position === 1)
															<option value="{{ e($member->username) }}" selected="selected"> {{ e($member->full_name) }}</option>
														@else
															<option value="{{ e($member->username) }}"> {{ e($member->full_name) }}</option>
														@endif
													@endforeach
												</select>
											</div>
										</div><!-- .form-group -->
										<div class="form-group">
											<label for="date_added" class="col-sm-4 control-label">Date Added</label>
											<div class="col-sm-8">
												<input type="date" class="form-control" id="date_added" name="date_added" value="{{ e(date('Y-m-d',strtotime($department->created_at))) }}" readonly>
											</div>
										</div><!-- .form-group -->
									</div>
								</div><!-- .row -->
								<div class="row pull-right">
									<div class="col-lg-12">
										<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Save</button>
									</div>
								</div><!-- .row -->
								{{ Form::token() }}
							{{ Form::close() }}
						</div><!-- .panel-body -->
					</div><!-- .panel -->
				</div>
			</div><!-- .row -->
		</div>
	</div><!-- row -->
@stop

@section('sub-heading')
   {{ e($department->department_id) }}
@stop
