<?php namespace BCD\Employees;

use BCD\Employees\Employee;

class EmployeeRepository {
	/**
	* Persists an Employee
	*
	* @param Employee $employee
	*/
	public function save(Employee $employee) {
		return $employee->save();
	}

	/**
	* Update employee information
	*
	* @param String $username, String $first_name, String $middle_name, String $last_name, 
	* @param String $birthdate, String $address, String $email, String $mobile, Integer $department_id
	* @return boolean
	*/
	public function update($username, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department_id) {
		$employee = Employee::whereUsername($username)->firstOrFail();


		$employee->first_name = $first_name;
		$employee->middle_name = $middle_name;
		$employee->last_name = $last_name;
		$employee->birthdate = $birthdate;
		$employee->address = $address;
		$employee->email = $email;
		$employee->mobile = $mobile;
		$employee->department_id = $department_id;

		return $employee->push();
	}

	public function getRegisteredEmployees() {
		return Employee::where('position', '<', 2)->paginate(5); //exclude system administrator
	}

	/**
	* Find employee
	* 
	* @param String $username
	*/
	public function find($username) {
		return Employee::whereUsername($username)->firstOrFail();
	}

	/**
	* Soft delete employee profile
	*
	* @param String $username
	*/
	public function remove($username) {
		$employee = Employee::whereUsername($username)->firstOrFail();

		return $employee->delete();
	}

	public function search($search) {
		return Employee::search($search)->paginate(5);
	}
}