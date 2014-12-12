@extends('layout.inner.online-forms.master')

@section('content')
{{Form::open(['class' => 'form', 'role' => 'form', 'route' => ['prs.update']])}}
	<div class="row-fluid">
		<div class="col-lg-8 col-xs-8 form-inputs">
			<div class="form-group">
				<div class="row-fluid">
					<div class="col-lg-12 col-xs-12 first">
						<label for="payee_firstname" class="col-sm-2 control-label form-label">Payee</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="payee_firstname" name="payee_firstname"{{ (Input::old('payee_firstname')) ? ' value ="' . Input::old('payee_firstname') . '"' : '' }} placeholder="First Name">
							@if($errors->has('payee_firstname'))
								<p class="bg-danger">{{ $errors->first('payee_firstname') }}</p>
							@endif
						</div>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="payee_middlename" name="payee_middlename"{{ (Input::old('payee_middlename')) ? ' value ="' . Input::old('payee_middlename') . '"' : '' }} placeholder="Middle Name">
							@if($errors->has('payee_middlename'))
								<p class="bg-danger">{{ $errors->first('payee_middlename') }}</p>
							@endif
						</div>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="payee_lastname" name="payee_lastname"{{ (Input::old('payee_lastname')) ? ' value ="' . Input::old('payee_lastname') . '"' : '' }} placeholder="Last Name">
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
					<textarea class="form-control" id="particulars" name="particulars" rows="10" placeholder="Request Particulars">{{ (Input::old('particulars')) ? Input::old('particulars') : '' }}</textarea>
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
							<input type="date" class="form-control" id="date_requested" name="date_requested"{{ (Input::old('date_requested')) ? ' value ="' . Input::old('date_requested') . '"' : '' }}>
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
					<input type="text" class="form-control" id="total_amount" name="total_amount"{{ (Input::old('total_amount')) ? ' value ="' . Input::old('total_amount') . '"' : '' }} placeholder="Total Amount">
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
							{{ Form::select('client_id', $clients, Input::old('client_id'), array('class' => 'form-control', 'id' => 'charge_to')) }}
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
							<input type="text" class="form-control" id="check_num" name="check_num"{{ (Input::old('check_num')) ? ' value ="' . Input::old('check_num') . '"' : '' }} placeholder="Check Number">
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
							<input type="date" class="form-control" id="date_needed" name="date_needed"{{ (Input::old('date_needed')) ? ' value ="' . Input::old('date_needed') . '"' : '' }}>
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
							<input type="text" class="form-control" id="requested_by" name="requested_by" value="{{ e($currentUser->employee->full_name) }}" readonly>
							<!-- current user's username --><input type="hidden" id="requestor" name="requestor" value="{{ e($currentUser->username) }}"> <!-- current user's username -->
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
							{{ Form::select('department_id', $departments, Input::old('department_id'), array('class' => 'form-control')) }}
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
{{ Form::close() }}
@stop