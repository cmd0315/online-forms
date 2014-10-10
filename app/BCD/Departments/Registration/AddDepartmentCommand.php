<?php namespace BCD\Departments\Registration;

class AddDepartmentCommand {

	/**
	* @var String
	*/
	public $department_id;

	/**
	* @var String 
	*/
	public $department_name;

	/**
	* Constructor
	*
	* @param String
	*/
	function __construct($department_id, $department_name) {
		$this->department_id = $department_id;
		$this->department_name = $department_name;
	}
}