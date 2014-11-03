<?php namespace BCD\OnlineForms\Validation;

use Laracasts\Validation\FormValidator;

class ApprovalForm extends FormValidator {

	/**
	 * Validation rules for updating profile information
	 *
	 * @var array
	 */
	protected $rules = [
		'decisionOptions' => 'required'
	];


} 