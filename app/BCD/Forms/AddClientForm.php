<?php namespace BCD\Forms;

use Laracasts\Validation\FormValidator;

class AddClientForm extends FormValidator {

	/**
	* Validaton rules for creating client profile
	*
	* @var array
	*/
	protected $rules = [
		'client_id' => 'required|max:10|min:3|unique:clients',
		'client_name' => 'required|max:50|min:3|unique:clients',
		'address' => 'required|min:5',
		'cp_first_name' => 'required|max:50|min:2',
		'cp_middle_name' => 'required|max:50|min:2',
		'cp_last_name' => 'required|max:50|min:2',
		'email' => 'max:50|email',
		'mobile' => 'max:15|min:11',
		'telephone' => 'max:15|min:7'
	];
}