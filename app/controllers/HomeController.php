<?php

use BCD\Admin\Account;
use BCD\Forms\Login;
use Laracasts\Validation\FormValidationException;

class HomeController extends \BaseController {
	/**
	 * @var \BCD\Forms\Login
	 */
	protected $loginForm;

	function __construct(Login $loginForm) {
		$this->loginForm = $loginForm;
	}

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

		try {
			$this->loginForm->validate(Input::all());
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}


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
