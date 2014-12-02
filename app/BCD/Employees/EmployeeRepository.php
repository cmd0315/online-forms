<?php namespace BCD\Employees;

use BCD\Employees\Employee;

class EmployeeRepository {

	/**
	* Persists an Employee
	*
	* @param Employee $employee
	* @return Employee
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

	/**
	* Find employee
	* 
	* @param String $username
	* @return Employee
	*/
	public function find($username) {
		return Employee::withTrashed()->whereUsername($username)->firstOrFail();
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


	/**
	* Restore employee profile
	*
	* @param String $username
	* @return Employee
	*/
	public function restore($username) {
		$employee = $this->find($username);
		$employee->position = 0;
		$employee->save();
		return $employee->restore();
	}

	/**
	* Get all employees beside with position of system admin including softdeleted, to be ordered according to the date deleted
	*
	* @return Employee
	*/
	public function getRegisteredEmployees() {
		return Employee::withTrashed()->where('position', '<', 2)->orderBy('deleted_at', 'ASC'); //exclude system administrator
	}
	
	/**
	* Get all employees with the given department id
	*
	* @param String $departmentID
	* @return Employee
	*/
	public function getEmployeesByDepartment($departmentID) {
		return $this->getRegisteredEmployees()->where('department_id', $departmentID)->get();
	}

	/**
	* Get all employees with the given username
	*
	* @param String $username
	* @return Employee
	*/
	public function getEmployeesByUsername($username) {
		return Employee::where('username', $username)->firstOrFail();
	}

	/**
	* Get all employees by position to be listed on select tag
	*
	* @return Employee
	*/
	public function listEmployeesByPosition() {
		return Employee::where('position', '=', 1)->orderBy('last_name')->get()->lists('first_last_name', 'username');
	}
	
	/**
	* Return paginated results with search and filter values
	*
	* @param int $maxRowPerPage
	* @param String $search
	* @param array $filterOptions
	* @return QueryBuilder
	*/
	public function paginateResults($maxRowPerPage, $search, array $filterOptions) {
		return $this->getRegisteredEmployees()->search($search)->sort($filterOptions)->paginate($maxRowPerPage);
	}

	/**
	* Return total number of registered employees (except system admin)
	*
	* @return int 
	*/
	public function total() {
		return $this->getRegisteredEmployees()->count();
	}

	/**
	* Return total number of active employees (except system admin)
	*
	* @return int 
	*/
	public function activeTotal() {
		return Employee::all()->count();
	}

	/**
	* Return formatted results of table rows, to be used for exporting to excel
	*
	* @return array
	*/
	public function getCSVReport() {
		$employees = $this->getRegisteredEmployees()->get();

		$csvArray = [];
		$count = 0;

		foreach($employees as $employee) {

			$employeeArray = [
				'#' => ++$count,
				'Username' => $employee->username,
				'First Name' => $employee->first_name,
				'Middle Name' => $employee->middle_name,
				'Last Name' => $employee->last_name,
				'Birthdate' => $employee->birthdate,
				'Address' => $employee->address,
				'Email' => $employee->email,
				'Mobile' => $employee->mobile,
				'Department' => $employee->department->department_name,
				'Position' => $employee->position_title,
				'Created At' => $employee->account['created_at']->toDateTimeString(),
				'Updated At' => $employee->account['updated_at']->toDateTimeString()
			];

			if($employee->isDeleted()) {
				$employeeArray['Deleted At'] = $employee->account['deleted_at']->toDateTimeString();
			}

			array_push($csvArray, $employeeArray);
		}

		return $csvArray;
	}
}