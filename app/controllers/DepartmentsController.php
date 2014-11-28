<?php
use BCD\Core\CommandBus;
use BCD\Departments\Registration\AddDepartmentCommand;
use BCD\Departments\Registration\UpdateDepartmentCommand;
use BCD\Departments\Registration\RemoveDepartmentCommand;
use BCD\Departments\Registration\RestoreDepartmentCommand;
use BCD\Forms\AddDepartmentForm;
use BCD\Forms\UpdateDepartmentProfileForm;
use BCD\Departments\DepartmentRepository;
use BCD\ExportToExcel;

class DepartmentsController extends \BaseController {

	use CommandBus;

	/**
	* @var AddDepartmentForm $addDepartmentForm
	*/
	protected $addDepartmentForm;

	/**
	* @var UpdateDepartmentProfileForm $updateDepartmentProfileForm
	*/
	protected $updateDepartmentProfileForm;

	/**
	* @var DepartmentRepository $departments
	*/
	protected $departments;

	/**
	* Maximum number of rows to be display per page
	*
	* @var int $maxRowPerPage
	*/
	protected $maxRowPerPage;


	/**
	* Constructor
	*
	* @param AddDepartmentForm $addDepartmentForm 
	* @param UpdateDepartmentProfileForm $updateDepartmentProfileForm
	* @param DepartmentRepository $departments
	*/
	public function __construct(AddDepartmentForm $addDepartmentForm, UpdateDepartmentProfileForm $updateDepartmentProfileForm, DepartmentRepository $departments) {
		$this->addDepartmentForm = $addDepartmentForm;

		$this->updateDepartmentProfileForm = $updateDepartmentProfileForm;

		$this->departments = $departments;

		$this->maxRowPerPage = 5;

		$this->beforeFilter('auth');

		$this->beforeFilter('role:System Administrator', ['except' => 'show']);

		$this->beforeFilter('csrf', ['on' => 'post']);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function index()
	{
		$search = Request::get('q');
		$sortBy = Request::get('sortBy');
		$direction = Request::get('direction');

		$currentPage = 1;

		if (Request::get('page')) {
			$currentPage = Request::get('page');
		}

		$currentRow =  ($this->maxRowPerPage * ($currentPage - 1)) ;

		$departments = $this->departments->paginateResults($this->maxRowPerPage, $search, compact('sortBy', 'direction'));
		$active_departments = $this->departments->totalActive();
		$total_departments = $this->departments->total();

		return View::make('admin.display.list-departments', ['pageTitle' => 'Manage Department Records'], compact('departments', 'active_departments', 'total_departments', 'search', 'currentRow'));
	}


	/**
	 * Show the form for creating a department
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('admin.create.department', ['pageTitle' => 'Add Department Record']);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('department_id', 'department_name');

		try {
			$this->addDepartmentForm->validate($input);
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}

		extract($input);

		$registration = $this->execute(new AddDepartmentCommand($department_id, $department_name));

		if($registration) {
			Flash::success('Account for ' . $department_name . ' department has been successfully created! <a href="' . URL::route('departments.index') . '"> View list of departments.</a>');
		}
		else {
			Flash::error('Failed to create account for ' . $department_name .  ' department!');
		}

		return Redirect::route('departments.create');
	}


	/**
	 * Display profile summary of department
	 *
	 * @param  String  $departmentID
	 * @return View
	 */
	public function show($departmentID)
	{
		$department = $this->departments->getDepartmentByGeneratedID($departmentID);
		$members = $department->employees;
		return View::make('admin.display.department-profile', ['pageTitle' => 'Department Profile'], compact('department', 'members'));
	}


	/**
	 * Show the form for editing the department information
	 *
	 * @param  String  $departmentID
	 * @return View
	 */
	public function edit($departmentID)
	{
		$department = $this->departments->getDepartmentByGeneratedID($departmentID);
		$members = $department->employees;
		return View::make('admin.edit.department', ['pageTitle' => 'Edit Department Information'], compact('department', 'members'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  String  $id
	 * @return Redirect
	 */
	public function update($id)
	{
		$inputs = Input::only('department_id', 'department_name', 'department_head');

		try {
			$this->updateDepartmentProfileForm->validate($inputs);
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}

		extract($inputs);

		$updateDepartment = $this->execute(new UpdateDepartmentCommand($id, $department_id, $department_name, $department_head));

		if($updateDepartment) {
			Flash::success('Profile of ' . $department_name . ' has been successfully updated! <a href="' . URL::route('departments.show', $department_id) . '"> View department profile.</a>');
		}
		else {
			Flash::error('Failed to edit profile of ' . $department_name . ' department!');
		}

		return Redirect::route('departments.edit', $department_id);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  String  $departmentID
	 * @return Redirect
	 */
	public function destroy($departmentID)
	{
		$department_name = $this->departments->getDepartmentName($departmentID); 

		$removeDepartment = $this->execute(
			new RemoveDepartmentCommand($departmentID)
		);

		if($removeDepartment) {
			Flash::success('Account of ' . $department_name  . ' department has been successfully removed!');

		}
		else{
			Flash::success('Failed to remove account of ' . $department_name . ' department!');

		}
		
		return 	Redirect::route('departments.index');
	}


	/**
	* Export list of departments to Excel
	*
	* @return Excel
	*/
	public function export() 
	{
		$departments = $this->departments->getCSVReport();

		$excel = new ExportToExcel($departments, 'List of Departments');

		return $excel->export();
	}

	/**
	 * Restore department account of the specified resource from storage.
	 *
	 * @param  String  $departmentID
	 * @return Redirect
	 */
	public function restore($departmentID) {

		$restoreDepartment = $this->execute(
			new RestoreDepartmentCommand($departmentID)
		);

		$msg = '<a href="' . URL::route('departments.index') . '">View list of departments.</a>';

		if($restoreDepartment) {
			$msg = 'Department account for ' . $departmentID . ' has been successfully restored! ' . $msg;
			Flash::success($msg);

		}
		else{
			$msg = 'Failed to restore department account of ' . $departmentID . '! ' . $msg;
			Flash::success($msg);
		}
		
		return Redirect::route('departments.show', $departmentID);
	}


}
