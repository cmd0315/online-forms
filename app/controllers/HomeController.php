<?php

use BCD\Admin\Account;

class HomeController extends \BaseController {

	/**
	 * Display the home page
	 *
	 * @return home page view
	 */
	public function getIndex() {
		return View::make('home', ['pageTitle' => 'Home']);
	}

	/**
	 * Show the form for signing in.
	 *
	 * @return view for the signin form
	 */
	public function getSignIn() {
		return View::make('signin', ['pageTitle' => 'Sign In']);
	}


	/**
	 * Validates inputted login details with corresponding credentials stored in the accounts table
	 *
	 * @return dashboard view if successful else return a redirect to the signin form
	 */
	public function postSignIn() {
		$validator = Validator::make(Input::all(),
			array(
				'username' => 'required|max:20|min:5|',
				'password' => 'required'
			)
		);

		if($validator->fails()) {
			//Redirect to signin page if there are validation errors 
			return 	Redirect::route('home.signin')
					->withErrors($validator)
					->withInput();
		}
		else {
			$remember = (Input::has('remember')) ? true : false;

			$username = Input::get('username');
			$password = Input::get('password');

			$auth = Auth::attempt(array(
				'username' => $username,
				'password' => $password,
				'status' => 0
			), $remember);

			if($auth){
				//Redirect to intended page
				return Redirect::intended(URL::route('dashboard'))
						->with('global', 'Welcome, ' . $username . '!');
			}
			else {
				return  Redirect::route('home.signin')
						->with('global-error', 'Wrong username or password');
			}
		}

	}

	/**
	 * End session for authenticated user
	 *
	 * @return redirect to home page
	 */
	public function getSignOut() {
		Auth::logout();
		return Redirect::route('home')->with('global', "You are now logged out.");
	}

}
