<?php namespace BCD\OnlineForms\Rejection\Validation;

use Laracasts\Validation\FormValidator;

class RejectReasonForm extends FormValidator {

	/**
	 * Validation rules for updating profile information
	 *
	 * @var array
	 */
	protected $rules = [
		'forms' => 'required',
		'process_type' => 'required',
		'reason' => 'required|min:5'
	];


} 