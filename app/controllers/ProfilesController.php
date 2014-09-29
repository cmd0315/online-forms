<?php
use BCD\Employees\Employee;
use BCD\Forms\UpdateProfileForm;


class ProfilesController extends \BaseController {

	/**
	* @var Employee $user
	*/
	protected $user;

	/**
	* @var UpdateProfileForm updateProfileForm
	*/
	protected $updateProfileForm;

	/**
	* Constructor
	*
	* @param $updateProfileForm
	*/
	public function __construct(UpdateProfileForm $updateProfileForm) 
	{
		$this->user = new Employee;
		$this->updateProfileForm = $updateProfileForm;

		$this->beforeFilter('auth');

		$this->beforeFilter('csrf', ['on' => 'post']);
	}
	

	/**
	 * Display the specified resource.
	 *
	 * @param  String  $username
	 * @return Response
	 */
	public function show($username)
	{
		
		$user = $this->user->whereUsername($username)->firstOrFail();
		return View::make('account.settings.profile', ['pageTitle' => 'My Profile'], compact('user'));
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
		$this->updateProfileForm->validate($input);
		
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
