<?php

class HomeController extends \BaseController {
	
	/**
	* Constructor
	*/
	public function __construct() {

		$this->beforeFilter('guest');
	}
	/**
	 * Display the home page
	 *
	 * @return home page view
	 */
	public function index() {
		return View::make('home', ['pageTitle' => 'Home']);
	}


}
