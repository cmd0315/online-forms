<?php
use BCD\Employee\Employee;

class ProfilesController extends \BaseController {

	protected $user;

	public function __construct() {
		$this->user = new Employee;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = $this->user->whereUsername(Auth::user()->username)->firstOrFail();
		return View::make('account.settings.profile', ['pageTitle' => 'My Profile'], compact('user'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the employee profile information
	 *
	 * @param  String  $username
	 * @return View
	 */
	public function edit($username)
	{
		$employee = $this->user->whereUsername($username)->firstOrFail();
		return View::make('account.settings.update-profile', ['pageTitle' => 'Update Profile'], compact('employee'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
