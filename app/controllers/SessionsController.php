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
	 * @return Response
	 */
	public function create()
	{
		return View::make('signin', ['pageTitle' => 'Sign In']);
	}


	/**
	 * Logs in user to website
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('username', 'password');
		$this->loginForm->validate($input);

		$remember = (Input::has('remember')) ? true : false;

		if(Auth::attempt($input, $remember)){
			//Redirect to intended page
			return Redirect::intended('dashboard')
					->with('global', 'You are now logged in!');
		}
		else {
			return  Redirect::route('sessions.create')
					->with('global-error', 'Wrong username or password');
		}
	}


	/**
	 * Logout user
	 *
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::route('home')->with('global', "You are now logged out.");
	}


}
