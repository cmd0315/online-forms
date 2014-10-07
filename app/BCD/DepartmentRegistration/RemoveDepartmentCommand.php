<?php namespace BCD\DepartmentRegistration;

class RemoveDepartmentCommand {

	/**
	* String $department_id
	*/
	public $department_id;


	/**
	* Constructor
	*
	* @param String $department_id
	*/
	function __construct($department_id) {
		$this->department_id = $department_id;
	}
}