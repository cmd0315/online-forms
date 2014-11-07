<?php
use BCD\Core\CommandBus;
use BCD\Employees\Registration\RegisterEmployeeCommand;
use BCD\Employees\Registration\UpdateEmployeeCommand;
use BCD\Employees\Registration\RemoveEmployeeCommand;
use BCD\Forms\RegisterEmployeeForm;
use BCD\Forms\UpdateEmployeeForm;
use BCD\Employees\EmployeeRepository;
use BCD\Departments\DepartmentRepository;
use BCD\OnlineForms\ExportToExcel;

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
	* Constructor
	* Restrict access only for System Administrator
	* @param RegisterEmployeeForm $registerEmployeeForm
	*
	*/
	function __construct(RegisterEmployeeForm $registerEmployeeForm, UpdateEmployeeForm $updateEmployeeForm, EmployeeRepository $employees, DepartmentRepository $departments) {
		$this->registerEmployeeForm = $registerEmployeeForm;

		$this->updateEmployeeForm = $updateEmployeeForm;

		$this->employees = $employees;

		$this->departments = $departments;

		$this->beforeFilter('auth');

		$this->beforeFilter('role:System Administrator');

		$this->beforeFilter('csrf', array('on' => 'post'));
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

		$total_employees = $this->employees->total();

		$employees = $this->employees->paginateResults($search, compact('sortBy', 'direction'));
		//$employees = $this->employees->search($search)->paginate(5);

		return View::make('admin.display.list-employees', ['pageTitle' => 'Manage Employee Records'], compact('employees', 'total_employees', 'search'));
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
			Flash::success('Employee account for ' . $username . ' has been successfully created! <a href="' . URL::route('employees.index') . '"> View list of employees.</a>' );
		}
		else {
			Flash::error('Failed to create employee account of ' . $username . '!');
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
			Flash::success($username . ' employee account has been successfully updated! <a href="' . URL::route('employees.show', $username) . '"> View employee profile.</a>');
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
	 * @return Response
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
		
		return 	Redirect::route('employees.index');
	}

	/**
	* Export list of employees to Excel
	*
	* @return Excel
	*/
	public function export() 
	{
		$employees = $this->employees->getRegisteredEmployees()->get();

		$excel = new ExportToExcel($employees, 'List of Employees');

		return $excel->export();
	}

}
