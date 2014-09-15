<?php
use BCD\Employee\Account;

class AccountsController extends \BaseController {

	protected $account;

	public function __construct() {
		$this->account = new Account;
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
		
		$validator = Validator::make(Input::all(), 
			array(
				'old_password' => 'required',
				'password' => 'required|max:50|min:6',
				'password_again' => 'required|same:password'
			) 
		);


		if($validator->fails()) {
			return 	Redirect::route('accounts.edit', $username)
					->withErrors($validator)
					->withInput();
		}
		else {
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
		return  Redirect::route('accounts.edit', $username)
				->with('global-error', 'Cannot change password'); //fallback
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
