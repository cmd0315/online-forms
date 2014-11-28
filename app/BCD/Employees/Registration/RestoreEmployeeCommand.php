<?php namespace BCD\Employees\Registration;

class RestoreEmployeeCommand {

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