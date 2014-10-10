<?php namespace BCD\Employees\Registration;

class RemoveEmployeeCommand {

	/**
	* @var String $username
	*/
	public $username;

	/**
	* Constructor
	*
	*/
	function __construct($username) {
		$this->username = $username;
	}
}