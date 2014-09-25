<?php

class HomeController extends \BaseController {
	
	/**
	 * Display the home page
	 *
	 * @return home page view
	 */
	public function index() {
		return View::make('home', ['pageTitle' => 'Home']);
	}


}
