<?php
use BCD\Core\CommandBus;
use BCD\Employees\Registration\RegisterEmployeeCommand;
use BCD\Employees\Registration\UpdateEmployeeCommand;
use BCD\Employees\Registration\RemoveEmployeeCommand;
use BCD\Employees\Registration\RestoreEmployeeCommand;
use BCD\Forms\RegisterEmployeeForm;
use BCD\Forms\UpdateEmployeeForm;
use BCD\Employees\EmployeeRepository;
use BCD\Departments\DepartmentRepository;
use BCD\ExportToExcel;

class EmployeesController extends \BaseController {

	use CommandBus;

	/**
	* @var RegisterEmployeeForm $registerEmployeeForm
	*/
	private $registerEmployeeForm;

	/**
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
	* Maximum number of rows to be display per page
	*
	* @var int $maxRowPerPage
	*/
	protected $maxRowPerPage;


	/**
	* Constructor
	* Restrict access only for System Administrator
	*
	* @param RegisterEmployeeForm $registerEmployeeForm
	* @param UpdateEmployeeForm $updateEmployeeForm
	* @param EmployeeRepository $employees
	* @param DepartmentRepository $departments
	*/
	function __construct(RegisterEmployeeForm $registerEmployeeForm, UpdateEmployeeForm $updateEmployeeForm, EmployeeRepository $employees, DepartmentRepository $departments) {
		$this->registerEmployeeForm = $registerEmployeeForm;

		$this->updateEmployeeForm = $updateEmployeeForm;

		$this->employees = $employees;

		$this->departments = $departments;

		$this->maxRowPerPage = 5;

		$this->beforeFilter('auth');

		$this->beforeFilter('role:System Administrator');

		//$this->beforeFilter('profileEditable', ['only' => 'edit']);

		$this->beforeFilter('csrf', ['on' => 'post']);
	}

	/**
	 * Display a listing of employee records
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

		$total_employees = $this->employees->total();
		$active_employees = $this->employees->activeTotal();

		$employees = $this->employees->paginateResults($this->maxRowPerPage, $search, compact('sortBy', 'direction'));

		return View::make('admin.display.list-employees', ['pageTitle' => 'Manage Employee Records'], compact('employees', 'active_employees', 'total_employees', 'search', 'currentRow'));
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
	 * @return Redirect
	 */
	public function store()
	{
		try {
			$this->registerEmployeeForm->validate(Input::all());
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}

		extract(Input::only('username', 'password', 'first_name', 'middle_name', 'last_name', 'birthdate', 'address', 'email', 'mobile', 'department'));

		$registration = $this->execute(
			new RegisterEmployeeCommand($username, $password, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department)
		);

		$employee_name = '<strong>' . $first_name . ' ' . $middle_name . ' ' . $last_name . '</strong>';

		if($registration) {
			Flash::success('Employee account for ' . $employee_name . ' has been successfully created! <a href="' . URL::route('employees.index') . '"> View list of employees.</a>' );
		}
		else {
			Flash::error('Failed to create employee account of ' . $employee_name . '!');
		}
		
		return Redirect::route('employees.create');
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
	 * @return Redirect
	 */
	public function update($username)
	{
		try {
			$this->updateEmployeeForm->validate(Input::all());
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}

		extract(Input::only('first_name', 'middle_name', 'last_name', 'birthdate', 'address', 'email', 'mobile', 'department'));

		$updateEmployee = $this->execute(
			new UpdateEmployeeCommand($username, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department)
		);

		if($updateEmployee) {
			Flash::success('Employee account of ' . $username .' has been successfully updated! <a href="' . URL::route('employees.show', $username) . '"> View employee profile.</a>');
		}
		else {
			Flash::error('Failed to update employee account of ' . $username . '!');
		}	

		return Redirect::route('employees.edit', $username);	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  String  $username
	 * @return Redirect
	 */
	public function destroy($username)
	{
		$removeEmployee = $this->execute(
			new RemoveEmployeeCommand($username)
		);

		if($removeEmployee) {
			Flash::success('Employee account of ' . $username . ' has been successfully removed!');

		}
		else{
			Flash::success('Failed to remove employee account of ' . $username . '!');
		}
		
		return Redirect::route('employees.index');
	}

	/**
	* Export list of employees to Excel
	*
	* @return Excel
	*/
	public function export() 
	{
		$employees = $this->employees->getCSVReport();

		$excel = new ExportToExcel($employees, 'List of Employees');

		return $excel->export();
	}

	/**
	 * Restore employee account and profile of the specified resource from storage.
	 *
	 * @param  String  $username
	 * @return Redirect
	 */
	public function restore($username) {

		$restoreEmployee = $this->execute(
			new RestoreEmployeeCommand($username)
		);

		$msg = '<a href="' . URL::route('employees.index') . '">View list of employees.</a>';

		if($restoreEmployee) {
			$msg = 'Employee account of ' . $username . ' has been successfully restored! ' . $msg;
			Flash::success($msg);

		}
		else{
			$msg = 'Failed to restore employee account of ' . $username . '! ' . $msg;
			Flash::success($msg);
		}
		
		return Redirect::route('employees.show', $username);
	}

}
