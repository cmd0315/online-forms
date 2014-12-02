<?php namespace BCD\Employees\Registration;

class RegisterEmployeeCommand {

	/**
	* @var mixed
	*/
	public $username, $password, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department_id;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($username, $password, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department_id) 
	{
		$this->username = $username;
		$this->password = $password;
		$this->first_name = $first_name;
		$this->middle_name = $middle_name;
		$this->last_name = $last_name;
		$this->birthdate = $birthdate;
		$this->address = $address;
		$this->email = $email;
		$this->mobile = $mobile;
		$this->department_id = $department_id;
	}
}