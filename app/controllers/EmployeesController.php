<?php
use BCD\Employee\Account;
use BCD\Employee\Employee;
use BCD\Department\Department;
use BCD\Forms\RegisterEmployee;
use Laracasts\Validation\FormValidationException;

class EmployeesController extends \BaseController {

	protected $registerEmployeeForm;

	function __construct(RegisterEmployee $registerEmployeeForm) {
		$this->registerEmployeeForm = $registerEmployeeForm;
	}

	/**
	 * Display a listing of employee records
	 *
	 * @return Response
	 */
	public function index()
	{
		$employees = Employee::where('position', '<', 2)->paginate(5); //exclude system administrator

		return View::make('admin.display.list-employees', ['pageTitle' => 'Manage Employee Records'], compact('employees'));
	}


	/**
	 * Show the form for adding an employee record
	 *
	 * @return Response
	 */
	public function create()
	{
		$departments = Department::orderBy('department_name')->lists('department_name', 'department_id');
		return View::make('admin.create.employee', ['pageTitle' => 'Add Employee Record'], compact('departments'));
	}


	/**
	 * Store a newly created employee record in the accounts and employees table
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			$this->registerEmployeeForm->validate(Input::all());
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}
		
		$username 			= Input::get('username');
		$password 			= Input::get('password');
		$first_name 		= Input::get('first_name');
		$middle_name 		= Input::get('middle_name');
		$last_name 			= Input::get('last_name');
		$birthdate			= Input::get('birthdate');
		$address			= Input::get('address');
		$email 				= Input::get('email');
		$mobile 			= Input::get('mobile');
		$department_id 		= Input::get('department');
		$department_name 	= Department::where('department_id', $department_id)->pluck('department_name');
		$position 			= Input::get('position');
		$recreate 			= Input::get('recreate');

		$department_head = Employee::where('department_id', $department_id)->head()->get();

		if($position == 1 && $department_head->count()) {
			return 	Redirect::route('employees.create')
					->with('global-error', 'Head employee for ' . $department_name . ' department already exists.')
					->withInput();
		}
		else {
			return $this->createAccount($username, $password, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department_id, $position);
		}

	}

	/**
	*
	* Insert employee record to accounts and employees tables
	* @param mixed
	* @return redirect to create employee account form with specific return msg
	*
	*/
	public function createAccount($username, $password, $firstName, $middleName, $lastName, $birthDate, $address, $email, $mobile, $departmentID, $position) {
		
		//Add to accounts table
		$account = Account::create(array(
			'username' => $username,
			'password' => Hash::make($password)
		));

		//Add to employees table
		$employee = Employee::create(array(
			'username' => $username,
			'first_name' => $firstName,
			'middle_name' => $middleName,
			'last_name' => $lastName,
			'birthdate' => $birthDate,
			'address' => $address,
			'email' => $email,
			'mobile' => $mobile,
			'department_id' => $departmentID,
			'position' => $position
		));

		if($account) {
			if($employee) {
				return 	Redirect::route('employees.create')
						->with('global-successful', 'Employee account successfully created!');
			}
			else {
				return 	Redirect::route('employees.create')
					->with('global-error', 'Failed to create employee profile!');
			}
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
	 * @return Response
	 */
	public function show($username)
	{
		$user = Employee::whereUsername($username)->firstOrFail();
		return View::make('account.settings.profile', ['pageTitle' => 'Employee Profile'], compact('user'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
