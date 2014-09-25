<?php
use BCD\Core\CommandBus;
use BCD\DepartmentRegistration\AddDepartmentCommand;
use BCD\DepartmentRegistration\UpdateDepartmentCommand;
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

		$this->beforeFilter('csrf', array('on' => 'post'));
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function index()
	{
		$departments = $this->departments->getList();
		return View::make('admin.display.list-departments', ['pageTitle' => 'Manage Department Records'], compact('departments'));
	}


	/**
	 * Show the form for creating a department
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('admin.create.department', ['pageTitle' => 'Add Department']);
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
			return 	Redirect::route('departments.create')
					->with('global-successful', 'Department Added!');
		}
		else {
				return 	Redirect::route('departments.create')
						->with('global-error', 'Failed to add department');
		}
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
			return 	Redirect::route('departments.edit', $department_id)
					->with('global-successful', 'Department Profile Updated!');
		}
		else {
			return 	Redirect::route('departments.edit', $department_id)
					->with('global-error', 'Failed to edit department');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
