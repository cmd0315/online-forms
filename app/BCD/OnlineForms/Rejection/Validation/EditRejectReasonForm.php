<?php namespace BCD\OnlineForms\Rejection\Validation;

use Laracasts\Validation\FormValidator;

class EditRejectReasonForm extends FormValidator {

	/**
	 * Validation rules for updating profile information
	 *
	 * @var array
	 */
	protected $rules = [
		'onlineForm' => 'required',
		'processType' => 'required',
		'reason' => 'required|min:5'
	];

} 