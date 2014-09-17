<?php
use BCD\Employee\Account;
use BCD\Forms\ChangePassword;
use Laracasts\Validation\FormValidationException;

class AccountsController extends \BaseController {

	protected $changePasswordForm;

	function __construct(ChangePassword $changePasswordForm) {
		$this->changePasswordForm  = $changePasswordForm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for changing the password of the logged in user.
	 *
	 * @param  String  $username
	 * @return Response
	 */
	public function edit($username)
	{
		return View::make('account.settings.change-password', ['pageTitle' => 'Change Password'], ['username' => $username]);
	}


	/**
	 * Update the password of the logged in user
	 *
	 * @param  String  $username
	 * @return Response
	 */
	public function update($username)
	{
		try {
			$this->changePasswordForm->validate(Input::all());
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}
		
		$user 				= $this->account->whereUsername($username)->firstOrFail();

		$old_password 		= Input::get('old_password');
		$new_password 		= Input::get('password');

		$return_msg = '';
		$global_type = '';

		if(Hash::check($old_password, $user->getAuthPassword())) {
			$user->password = Hash::make($new_password);

			if($user->save()){
				$global_type = 'global-successful';
				$return_msg = 'Password has been successfully changed!';
			}
		}
		else {
			$global_type = 'global-error';
			$return_msg = 'Old password given does not match record!';
		}

		return  Redirect::route('accounts.edit', $username)
				->with($global_type, $return_msg);
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
