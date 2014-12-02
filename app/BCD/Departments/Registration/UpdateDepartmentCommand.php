<?php namespace BCD\Departments\Registration;

class UpdateDepartmentCommand {
	/**
	* @var int $id
	*/
	public $id;

	/**
	* @var String $department_id
	*/
	public $department_id;

	/**
	* @var String $department_name
	*/
	public $department_name;

	/**
	* @var String $department_head
	*/
	public $department_head;


	/**
	* Constructor
	*
	* @param int $id
	* @param String $department_id
	* @param String $department_name
	* @param String $department_head
	*/
	function __construct($id, $department_id, $department_name, $department_head) {
		$this->id = $id;
		$this->department_id = $department_id;
		$this->department_name = $department_name;
		$this->department_head = $department_head;
	}
}