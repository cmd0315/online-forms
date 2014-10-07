<?php namespace BCD\Departments;

class DepartmentRepository {

	/**
	* Persists a Department
	*
	* @param Department $department
	*/
	public function save(Department $department) {
		return $department->save();
	}

	/**
	* Get all departments that are not deactivated
	*
	* @return Department
	*/
	public function getActiveDepartments() {
		return Department::where('status', '=', 0);
	}

	/**
	* Get all departments by name to be listed on select tag
	*
	* @return Department
	*/
	public function listDepartmentByName() {
		return Department::orderBy('department_name')->lists('department_name', 'department_id');
	}

	/**
	* Get all departments ordered by department name
	*
	* @return Department
	*/
	public function orderByName() {
		return Department::orderBy('department_name')->get();
	}

	/**
	* Get all departments ordered by department name with results paginated 
	*
	* @return Department
	*/
	public function getList() {
		return Department::orderBy('department_name')->paginate(5);
	}

	/**
	* Get department with given table id
	*
	* @param 
	* @return Department
	*/
	public function getDepartmentByID($id) {
		return Department::where('id', $id)->firstOrFail();
	}

	/**
	* Get department with system generated id
	*
	* @param String
	* @return Department
	*/
	public function getDepartmentByGeneratedID($id) {
		return Department::where('department_id', $id)->firstOrFail();
	}

	/**
	* Get departments that have specified id
	*
	* @param String
	* @return Department
	*/
	public function getDepartmentsByGeneratedID($id) {
		return Department::where('department_id', $id)->get();
	}

	/**
	* Return paginated results with search and filter values
	* @param String
	* @param array
	* @return QueryBuilder
	*/
	public function paginateResults($search, array $filterOptions) {
		return $this->getActiveDepartments()->search($search)->sort($filterOptions)->paginate(5);
	}
	
	/**
	* Return total number of active departments
	*
	* @return int
	*/
	public function total() {
		return $this->getActiveDepartments()->count();
	}

	/**
	* Soft delete department profile
	*
	* @param String $departmentID
	*/
	public function remove($departmentID) {
		$department = $this->getDepartmentByGeneratedID($departmentID);

		return $department->delete();
	}

}