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
	 * @return View
	 */
	public function index() {
		return View::make('home', ['pageTitle' => 'Home']);
	}


}
