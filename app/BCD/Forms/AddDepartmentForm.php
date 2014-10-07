<?php namespace BCD\Forms;

use Laracasts\Validation\FormValidator;

class AddDepartmentForm extends FormValidator {

	/**
	 * Validation rules for adding a department
	 *
	 * @var array
	 */
	protected $rules = [
		'department_id' => 'required|max:10|min:4|unique:departments',
		'department_name' => 'required|max:20|min:2|unique:departments'
	];

} 