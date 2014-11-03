@extends('layout.inner.forms.master')

@section('content')
{{ Form::open(['class' => 'form-horizontal', 'route' => ['rfps.update', $formNum = e($form->form_num)], 'method' => 'PATCH'])}}
	<div class="row-fluid">
		<div class="col-lg-8 col-xs-8 form-inputs">
			<div class="form-group">
				<div class="row-fluid">
					<div class="col-lg-12 col-xs-12 first">
						<label for="payee_firstname" class="col-sm-2 control-label form-label">Payee</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="payee_firstname" name="payee_firstname" value="{{e($form->payee_firstname)}}">
							@if($errors->has('payee_firstname'))
								<p class="bg-danger">{{ $errors->first('payee_firstname') }}</p>
							@endif
						</div>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="payee_middlename" name="payee_middlename" value="{{e($form->payee_middlename)}}">
							@if($errors->has('payee_middlename'))
								<p class="bg-danger">{{ $errors->first('payee_middlename') }}</p>
							@endif
						</div>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="payee_lastname" name="payee_lastname" value="{{e($form->payee_lastname)}}">
							@if($errors->has('payee_lastname'))
								<p class="bg-danger">{{ $errors->first('payee_lastname') }}</p>
							@endif
						</div>
					</div>
				</div><!-- row-fluid -->
			</div><!-- .form-group -->
			<div class="form-group">
				<label for="particulars" class="col-sm-2 control-label form-label">Particulars</label>
				<div class="col-sm-10">
					<textarea class="form-control" id="particulars" name="particulars" rows="10" placeholder="Request Particulars">{{ e($form->particulars) }}</textarea>
					@if($errors->has('particulars'))
						<p class="bg-danger">{{ $errors->first('particulars') }}</p>
					@endif
				</div>
			</div><!-- .form-group -->
		</div><!-- .form-inputs -->
		<div class="col-lg-4 col-xs-4 form-inputs right">
			<div class="form-group">
				<div class="row-fluid">
					<div class="col-lg-12 col-xs-12 first">
						<label for="date_requested" class="col-sm-2 control-label form-label">Date</label>
						<div class="col-sm-10">
							<input type="date" class="form-control" id="date_requested" name="date_requested" value="{{ e($form->date_requested) }}">
							@if($errors->has('date_requested'))
								<p class="bg-danger">{{ $errors->first('date_requested') }}</p>
							@endif
						</div>
					</div><!-- .first -->
				</div><!-- row-fluid -->
			</div><!-- .form-group -->
		    <div class="form-group">
				<label for="total_amount" class="col-sm-3 control-label form-label">Amount</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="total_amount" name="total_amount" value="{{ e($form->total_amount_formatted) }}">
					@if($errors->has('total_amount'))
						<p class="bg-danger">{{ $errors->first('total_amount') }}</p>
					@endif
				</div>
		    </div>
		</div>
	</div><!-- .row-fluid -->
	<div class="row-fluid form-divider">
		<div class="col-lg-4 col-xs-4 form-inputs form-meta">
			<div class="form-group">
				<div class="row-fluid">
					<div class="col-lg-12 col-xs-12 meta-firsts">
						<label for="client_id" class="col-sm-5 control-label form-label">Charge to (Client/Project)</label>
						<div class="col-sm-7">
							<select class="form-control" id="client_id" name="client_id">
								@foreach($clients as $client)
									@if(e($form->onlineForm->client_id) == e($client->client_id))
										<option value="{{ e($client->client_id) }}" selected="selected">{{ e($client->client_id) }}</option>
									@else
										<option value="{{ e($client->client_id) }}">{{ e($client->client_id) }}</option>
									@endif
								@endforeach
							</select>
							@if($errors->has('client_id'))
								<p class="bg-danger">{{ $errors->first('client_id') }}</p>
							@endif
						</div>
					</div>
				</div><!-- .row-fluid -->
			</div><!-- .form-group -->
			<div class="form-group">
				<div class="row-fluid">
					<div class="col-lg-12 meta-firsts">
						<label for="check_num" class="col-sm-4 control-label form-label">C.E. No.</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="check_num" name="check_num" value="{{e($form->check_num)}}">
							@if($errors->has('check_num'))
								<p class="bg-danger">{{ $errors->first('check_num') }}</p>
							@endif
						</div>
					</div>
				</div><!-- .row-fluid -->
			</div><!-- .form-group -->
			<div class="form-group">
				<div class="row-fluid">
					<div class="col-lg-12 col-xs-12">
						<label for="date_needed" class="col-sm-4 control-label form-label">Date Needed</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="date_needed" name="date_needed" value="{{e($form->date_needed)}}">
							@if($errors->has('date_needed'))
								<p class="bg-danger">{{ $errors->first('date_needed') }}</p>
							@endif
						</div>
					</div><!-- .meta-firsts -->
				</div><!-- .row-fluid -->
			</div><!-- .form-group -->
		</div><!-- .form-meta -->
		<div class="col-lg-4 col-lg-offset-1 col-xs-4 col-xs-offset-1 form-inputs form-meta">
			<div class="form-group">
				<div class="row-fluid">
					<div class="col-lg-12 meta-firsts">
						<label for="requested_by" class="col-sm-5 control-label form-label">Requested By</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="requested_by" name="requested_by" value="{{ e($form->onlineForm->creator->first_last_name) }}" readonly>
							<!-- current user's username --><input type="hidden" id="requestor" name="requestor" value="{{ e($form->onlineForm->creator->username) }}"> <!-- current user's username -->
							@if($errors->has('requested_by'))
								<p class="bg-danger">{{ $errors->first('requested_by') }}</p>
							@endif
						</div>
					</div><!-- .meta-firsts -->
				</div> <!-- .row-fluid -->
			</div> <!-- .form-group -->
            <div class="form-group">
				<div class="row-fluid">
					<div class="col-lg-12 col-xs-12">
						<label for="department_id" class="col-sm-4 control-label form-label">Department</label>
						<div class="col-sm-8">
							<select class="form-control" id="department_id" name="department_id">
								@foreach($departments as $department)
									@if(e($form->onlineForm->department_id) == e($department->department_id))
										<option value="{{ e($department->department_id) }}" selected="selected">{{ e($department->department_name) }}</option>
									@else
										<option value="{{ e($department->department_id) }}">{{ e($department->department_name) }}</option>
									@endif
								@endforeach
							</select>
							@if($errors->has('department_id'))
								<p class="bg-danger">{{ $errors->first('department_id') }}</p>
							@endif
		                </div>
					</div><!-- .meta-firsts -->
				</div><!-- .row-fluid -->
            </div><!-- .form-group -->
		</div><!-- .form-meta -->
		<div class="col-lg-3 col-xs-3">
			@include('layout.partials._bcd-ci')
		</div>
	</div><!-- .row-fluid -->
	<div class="row-fluid">
		<div class="col-lg-12 col-xs-12 mt text-right">
			<button type="submit" class="btn btn-lg btn-warning" id="submit_form" name="submit_form">Submit</button>
		</div>
	</div><!-- .row-fluid -->
	<input type="hidden" id="form_num" name="form_num" value="{{ $formNum }}">
	{{ Form::token() }}
{{ Form::close() }}
@stop