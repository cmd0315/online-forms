<?php namespace BCD\DepartmentRegistration;

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
	*/
	function __construct($department_id, $department_name) {
		$this->department_id = $department_id;
		$this->department_name = $department_name;
	}
}