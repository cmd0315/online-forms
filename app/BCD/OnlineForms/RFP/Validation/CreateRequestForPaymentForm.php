<?php namespace BCD\OnlineForms\RFP\Validation;

use Laracasts\Validation\FormValidator;

class CreateRequestForPaymentForm extends FormValidator {

	/**
	 * Validation rules for updating profile information
	 *
	 * @var array
	 */
	protected $rules = [
		'form_num' => 'required',
		'payee_firstname' => 'required|max:50|min:2',
		'payee_lastname' => 'required|max:50|min:2',
		'particulars' => 'required|min:2|max:100',
		'date_requested' => 'required|date',
		'total_amount' => 'required|numeric',
		'client_id' => 'required',
		'check_num' => 'numeric',
		'department_id' => 'required',
		'approved_by' => 'required',
		'date_needed' => 'required|date',
	];

} 