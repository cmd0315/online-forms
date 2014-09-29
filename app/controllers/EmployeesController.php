<?php
use BCD\Core\CommandBus;
use BCD\Registration\RegisterEmployeeCommand;
use BCD\Registration\UpdateEmployeeCommand;
use BCD\Registration\RemoveEmployeeCommand;
use BCD\Forms\RegisterEmployeeForm;
use BCD\Forms\UpdateEmployeeForm;
use BCD\Employees\EmployeeRepository;
use BCD\Departments\DepartmentRepository;

class EmployeesController extends \BaseController {

	use CommandBus;

	/**
	*
	* @var RegisterEmployeeForm $registerEmployeeForm
	*/
	private $registerEmployeeForm;

	/**
	*
	* @var UpdateEmployeeForm $updateEmployeeForm
	*/
	private $updateEmployeeForm;

	/**
	* @var EmployeeRepository $employees
	*/
	protected $employees;

	/**
	* @var DepartmentRepository $departments
	*/
	protected $departments;

	/**
	* Constructor
	*
	* @param RegisterEmployeeForm $registerEmployeeForm
	*
	*/
	function __construct(RegisterEmployeeForm $registerEmployeeForm, UpdateEmployeeForm $updateEmployeeForm, EmployeeRepository $employees, DepartmentRepository $departments) {
		$this->registerEmployeeForm = $registerEmployeeForm;

		$this->updateEmployeeForm = $updateEmployeeForm;

		$this->employees = $employees;

		$this->departments = $departments;

		$this->beforeFilter('auth');

		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	/**
	 * Display a listing of employee records
	 *
	 * @return View
	 */
	public function index()
	{	
		$search = '';
		
		if($search = Request::get('q')) {
			$employees = $this->employees->search($search);
		}
		else {
			$employees = $this->employees->getRegisteredEmployees();
		}

		return View::make('admin.display.list-employees', ['pageTitle' => 'Manage Employee Records'], compact('employees', 'search'));
	}


	/**
	 * Show the form for adding an employee record
	 *
	 * @return View
	 */
	public function create()
	{
		$departments = $this->departments->listDepartmentByName();
		return View::make('admin.create.employee', ['pageTitle' => 'Add Employee Record'], compact('departments'));
	}


	/**
	 * Store a newly created employee record in the accounts and employees table
	 *
	 * @return View
	 */
	public function store()
	{
		$this->registerEmployeeForm->validate(Input::all());

		extract(Input::only('username', 'password', 'first_name', 'middle_name', 'last_name', 'birthdate', 'address', 'email', 'mobile', 'department'));

		$registration = $this->execute(
			new RegisterEmployeeCommand($username, $password, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department)
		);

		if($registration) {
			return 	Redirect::route('employees.create')
						->with('global-successful', 'Employee account successfully created!');
		}
		else {
			return 	Redirect::route('employees.create')
					->with('global', 'Failed to create employee account!');
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  String  $username
	 * @return View
	 */
	public function show($username)
	{
		$user = $this->employees->find($username);
		return View::make('account.settings.profile', ['pageTitle' => 'Employee Profile'], compact('user'));
	}


	/**
	 * Show the form for editing employee information.
	 *
	 * @param  String $username
	 * @return View
	 */
	public function edit($username)
	{
		$employee = $this->employees->find($username);
		$departments = $this->departments->orderByName();
		return View::make('admin.edit.employee', ['pageTitle' => 'Edit Employee Profile'], compact('employee', 'departments'));
	}


	/**
	 * Update the employee information
	 *
	 * @param  String $username
	 * @return View
	 */
	public function update($username)
	{
		$this->updateEmployeeForm->validate(Input::all());

		extract(Input::only('first_name', 'middle_name', 'last_name', 'birthdate', 'address', 'email', 'mobile', 'department'));

		$updateEmployee = $this->execute(
			new UpdateEmployeeCommand($username, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department)
		);

		if($updateEmployee) {
			return 	Redirect::route('employees.edit', $username)
						->with('global-successful', 'Employee account successfully updated!');
		}
		else {
			return 	Redirect::route('employees.edit', $username)
					->with('global', 'Failed to update employee account!');
		}		

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  String  $username
	 * @return Response
	 */
	public function destroy($username)
	{
		$removeEmployee = $this->execute(
			new RemoveEmployeeCommand($username)
		);

		if($removeEmployee) {
			return 	Redirect::route('employees.index')
						->with('global-successful', 'Employee account successfully removed!');

		}
		else{
			return 	Redirect::route('employees.edit', $username)
					->with('global', 'Failed to remove employee account!');

		}
	}


}
