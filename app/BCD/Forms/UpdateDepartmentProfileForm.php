<?php namespace BCD\Forms;

use Laracasts\Validation\FormValidator;

class UpdateDepartmentProfileForm extends FormValidator {

	/**
	 * Validation rules for adding a department
	 *
	 * @var array
	 */
	protected $rules = [
		'department_id' => 'required|max:10|min:4',
		'department_head' => 'required'
	];

} 