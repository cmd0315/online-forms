<?php
use BCD\Employees\Account;
use BCD\Forms\ChangePasswordForm;
use Laracasts\Validation\FormValidationException;

class AccountsController extends \BaseController {

	/**
	* @var ChangePasswordForm $changePasswordForm
	*/
	protected $changePasswordForm;

	/**
	* Constructor
	*
	* @param ChangePasswordForm $changePasswordForm
	*/
	function __construct(ChangePasswordForm $changePasswordForm) {
		$this->changePasswordForm  = $changePasswordForm;
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	/**
	 * Show the form for changing the password of the logged in user.
	 *
	 * @param  String  $username
	 * @return View
	 */
	public function edit($username)
	{
		return View::make('account.settings.change-password', ['pageTitle' => 'Change Password'], ['username' => $username]);
	}


	/**
	 * Update the password of the logged in user
	 *
	 * @param  String  $username
	 * @return Redirect
	 */
	public function update($username)
	{
		try {
			$this->changePasswordForm->validate(Input::all());
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}
		
		$user 				= Account::whereUsername($username)->firstOrFail();

		$old_password 		= Input::get('old_password');
		$new_password 		= Input::get('password');

		if(Hash::check($old_password, $user->getAuthPassword())) {
			$user->password = $new_password;

			if( !($user->save()) ){
				Flash::error('Error: Failed saving new password!');
			}
			Flash::success('Password has been successfully changed!');
		}
		else {
			Flash::error('Old password given does not match record!');
		}

		return  Redirect::route('accounts.edit', $username);
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
