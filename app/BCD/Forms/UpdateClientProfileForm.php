<?php namespace BCD\Forms;

use Laracasts\Validation\FormValidator;

class UpdateClientProfileForm extends FormValidator {

	/**
	* Validaton rules for creating client profile
	*
	* @var array
	*/
	protected $rules = [
		'client_id' => 'max:10|min:3',
		'client_name' => 'max:50|min:3',
		'address' => 'required|min:5',
		'cp_first_name' => 'required|max:50|min:2',
		'cp_middle_name' => 'required|max:50|min:2',
		'cp_last_name' => 'required|max:50|min:2',
		'email' => 'max:50|email',
		'mobile' => 'max:15|min:11',
		'telephone' => 'max:15|min:7'
	];
}