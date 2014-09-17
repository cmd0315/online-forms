<?php namespace BCD\Forms;

use Laracasts\Validation\FormValidator;

class ChangePassword extends FormValidator {

	/**
	 * Validation rules for changing password
	 *
	 * @var array
	 */
	protected $rules = [
		'old_password' => 'required',
		'password' => 'required|max:50|min:6',
		'password_again' => 'required|same:password'
	];

} 