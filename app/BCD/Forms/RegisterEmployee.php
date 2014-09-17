<?php namespace BCD\Forms;

use Laracasts\Validation\FormValidator;

class RegisterEmployee extends FormValidator {

	/**
	 * Validation rules for logging in
	 *
	 * @var array
	 */
	protected $rules = [
		'username' => 'required|max:20|min:5|unique:accounts',
		'password' => 'required|max:50|min:6',
		'password_again' => 'required|same:password',
		'first_name' => 'required|max:50|min:2',
		'middle_name' => 'required|max:50|min:2',
		'last_name' => 'required|max:50|min:2',
		'email' => 'required|max:50|email|unique:employees',
		'birthdate' => 'required',
		'address' => 'required|min:5',
		'mobile' => 'max:15|min:11',
		'position' => 'required',
		'department' => 'required'
	];

} 