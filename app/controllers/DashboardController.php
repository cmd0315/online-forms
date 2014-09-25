<?php
use BCD\Employees\Employee;

class DashboardController extends \BaseController {
	
	/**
	* Constructor
	*/
	function __construct() {
		$this->beforeFilter('auth');
	}
	/**
	 * Display the home page
	 *
	 * @return View
	 */
	public function index() {
		return View::make('account.dashboard', ['pageTitle' => 'Dashboard']);
	}

	

}
