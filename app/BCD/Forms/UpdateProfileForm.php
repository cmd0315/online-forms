<?php namespace BCD\Forms;

use Laracasts\Validation\FormValidator;

class UpdateProfileForm extends FormValidator {

	/**
	 * Validation rules for updating profile information
	 *
	 * @var array
	 */
	protected $rules = [
		'first_name' => 'required|max:50|min:2',
		'middle_name' => 'required|max:50|min:2',
		'last_name' => 'required|max:50|min:2',
		'address' => 'required|min:5',
		'birthdate' => 'required',
		'email' => 'required',
		'mobile' => 'max:15|min:11'
	];

} 