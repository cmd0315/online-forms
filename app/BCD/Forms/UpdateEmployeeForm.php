<?php namespace BCD\Forms;

use Laracasts\Validation\FormValidator;

class UpdateEmployeeForm extends FormValidator {

	/**
	 * Validation rules for updating employee information
	 *
	 * @var array
	 */
	protected $rules = [
		'first_name' => 'required|max:50|min:2',
		'middle_name' => 'required|max:50|min:2',
		'last_name' => 'required|max:50|min:2',
		'email' => 'required|max:50|email',
		'birthdate' => 'required',
		'address' => 'required|min:5',
		'mobile' => 'max:15|min:11',
		'department' => 'required'
	];

} 