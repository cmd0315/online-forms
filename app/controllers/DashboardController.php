<?php
use BCD\Employee\Employee;

class DashboardController extends \BaseController {

	/**
	 * Display the home page
	 *
	 * @return home page view
	 */
	public function getIndex() {
		return View::make('account.dashboard', ['pageTitle' => 'Dashboard']);
	}

	

}
