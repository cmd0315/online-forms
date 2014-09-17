<?php
use BCD\Employee\Employee;
use BCD\Forms\UpdateProfile;
use Laracasts\Validation\FormValidationException;


class ProfilesController extends \BaseController {

	protected $user;
	protected $updateProfileForm;

	public function __construct(UpdateProfile $updateProfileForm) {
		$this->user = new Employee;
		$this->updateProfileForm = $updateProfileForm;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = $this->user->whereUsername(Auth::user()->username)->firstOrFail();
		return View::make('account.settings.profile', ['pageTitle' => 'My Profile'], compact('user'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the employee profile information
	 *
	 * @param  String  $username
	 * @return View
	 */
	public function edit($username)
	{
		$employee = $this->user->whereUsername($username)->firstOrFail();
		return View::make('account.settings.update-profile', ['pageTitle' => 'Update Profile'], compact('employee'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  String  $username
	 * @return Response
	 */
	public function update($username)
	{
		//check if user exists
		try {
			$employee = $this->user->whereUsername($username)->firstOrFail();
		}
		catch(ModelNotFoundException $e) {
			return  Redirect::route('profile.edit', ['username' => $username])
					->with('global-error', 'System error: Saving employee information failed');
		}

		//validate form
		$input = Input::only('first_name', 'middle_name', 'last_name', 'birthdate', 'address', 'email', 'mobile');
		try {
			$this->updateProfileForm->validate($input);
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withErrors($error->getErrors())->withInput();
		}

		$employee->fill($input)->save();
		return 	Redirect::back()
				->with('global-successful', 'Profile information successfully changed!');
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
