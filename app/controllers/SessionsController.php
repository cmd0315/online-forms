<?php
 use BCD\Forms\LoginForm;

class SessionsController extends \BaseController {
	/**
	* @var $loginForm
	*/
	private $loginForm;

	/**
	* Constructor
	*
	* @param $loginForm
	*/
	function __construct(LoginForm $loginForm) {
		$this->loginForm = $loginForm;
		$this->beforeFilter('guest', ['except' => 'destroy']);
	}

	
	/**
	 * Show the form for signing in.
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('signin', ['pageTitle' => 'Sign In']);
	}


	/**
	 * Logs in user to website
	 *
	 * @return Redirect
	 */
	public function store()
	{
		$input = Input::only('username', 'password');
		$this->loginForm->validate($input);

		$remember = (Input::has('remember')) ? true : false;

		if( !(Auth::attempt($input, $remember)) ){
			return  Redirect::route('sessions.create')
					->with('global-error', 'Wrong username or password');
		}

		//Redirect to intended page
		return Redirect::intended('dashboard')
				->with('global', 'You are now logged in!');
	}


	/**
	 * Logout user
	 *
	 * @return Redirect
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::route('home')->with('global', "You have been logged out.");
	}


}
