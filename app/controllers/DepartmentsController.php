<?php
use BCD\Core\CommandBus;
use BCD\Departments\Registration\AddDepartmentCommand;
use BCD\Departments\Registration\UpdateDepartmentCommand;
use BCD\Departments\Registration\RemoveDepartmentCommand;
use BCD\Forms\AddDepartmentForm;
use BCD\Forms\UpdateDepartmentProfileForm;
use BCD\Departments\DepartmentRepository;

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
	* Constructor
	*
	* @param AddDepartmentForm $addDepartmentForm 
	* @param UpdateDepartmentProfileForm $updateDepartmentProfileForm
	*/
	public function __construct(AddDepartmentForm $addDepartmentForm, UpdateDepartmentProfileForm $updateDepartmentProfileForm, DepartmentRepository $departments) {
		$this->addDepartmentForm = $addDepartmentForm;

		$this->updateDepartmentProfileForm = $updateDepartmentProfileForm;

		$this->departments = $departments;

		$this->beforeFilter('auth');

		$this->beforeFilter('role:System Administrator');

		$this->beforeFilter('csrf', array('on' => 'post'));
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

		$departments = $this->departments->paginateResults($search, compact('sortBy', 'direction'));
		$total_departments = $this->departments->total();
		return View::make('admin.display.list-departments', ['pageTitle' => 'Manage Department Records'], compact('departments', 'total_departments', 'search'));
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
		$this->addDepartmentForm->validate($input);

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
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::only('department_id', 'department_name', 'department_head');

		$this->updateDepartmentProfileForm->validate($input);

		extract($input);

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
	 * @param  String  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$department_name = $this->departments->getDepartmentName($id); 

		$removeDepartment = $this->execute(
			new RemoveDepartmentCommand($id)
		);

		if($removeDepartment) {
			Flash::success('Account of ' . $department_name  . ' department has been successfully removed!');

		}
		else{
			Flash::success('Failed to remove account of ' . $department_name . ' department!');

		}
		
		return 	Redirect::route('departments.index');
	}


}
