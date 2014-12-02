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
	* Get all departments including softdeleted, to be ordered according to the date deleted
	*
	* @return Department
	*/
	public function getAll() {
		return Department::withTrashed()->orderBy('deleted_at', 'ASC');
	}

	/**
	* Get all departments that are not deactivated
	*
	* @return Department
	*/
	public function getActiveDepartments() {
		return Department::whereNull('deleted_at');
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
	* @param int $id 
	* @return Department
	*/
	public function getDepartmentByID($id) {
		return $this->getAll()->where('id', $id)->firstOrFail();
	}

	/**
	* Get department with system generated id
	*
	* @param String $departmentID
	* @return Department
	*/
	public function getDepartmentByGeneratedID($departmentID) {
		return $this->getAll()->where('department_id', $departmentID)->firstOrFail();
	}

	/**
	* Get departments that have specified id
	*
	* @param String $departmentID
	* @return Department
	*/
	public function getDepartmentsByGeneratedID($departmentID) {
		return $this->getAll()->where('department_id', $departmentID)->get();
	}

	/**
	* Return name of the department
	*
	* @param String $departmentID
	* @return String
	*/
	public function getDepartmentName($departmentID) {
		return $this->getAll()->where('department_id', $departmentID)->pluck('department_name');
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
		return $this->getAll()->search($search)->sort($filterOptions)->paginate($maxRowPerPage);
	}
	
	/**
	* Return total number of active departments
	*
	* @return int
	*/
	public function total() {
		return $this->getAll()->count();
	}

   /**
	* Return total number of active departments
	*
	* @return int
	*/
	public function totalActive() {
		return $this->getActiveDepartments()->count();
	}

	/**
	* Soft delete department profile
	*
	* @param String $departmentID
	* @return Department
	*/
	public function remove($departmentID) {
		$department = $this->getDepartmentByGeneratedID($departmentID);

		return $department->delete();
	}

	/**
	* Restore department account
	*
	* @param String $departmentID
	* @return Department
	*/
	public function restore($departmentID) {
		$department = $this->getDepartmentByGeneratedID($departmentID);

		return $department->restore();
	}

	/**
	* Return formatted results of table rows, to be used for exporting to excel
	*
	* @return array
	*/
	public function getCSVReport() {
		$departments = $this->getAll()->get();

		$csvArray = [];
		$count = 0;

		foreach($departments as $department) {

			$departmentArr = [
				'#' => ++$count,
				'Department ID' => $department->department_id,
				'Department Name' => $department->department_name,
				'Department Head' => $department->department_head,
				'Status' => $department->status,
				'Created At' => $department['created_at']->toDateTimeString(),
				'Updated At' => $department['updated_at']->toDateTimeString()
			];

			if($department->isDeleted()) {
				$departmentArr['Deleted At'] = $department['deleted_at']->toDateTimeString();
			}

			array_push($csvArray, $departmentArr);
		}

		return $csvArray;
	}

}