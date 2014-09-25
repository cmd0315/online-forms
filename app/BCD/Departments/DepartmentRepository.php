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

	public function listDepartmentByName() {
		return Department::orderBy('department_name')->lists('department_name', 'department_id');
	}

	public function orderByName() {
		return Department::orderBy('department_name')->get();
	}

	public function getList() {
		return Department::orderBy('department_name')->paginate(5);
	}

	public function getDepartmentByID($id) {
		return Department::where('id', $id)->firstOrFail();
	}

	public function getDepartmentByGeneratedID($id) {
		return Department::where('department_id', $id)->firstOrFail();
	}

}