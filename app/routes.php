<?php
/* Home */
Route::get('/',[
	'as' => 'home',
	'uses' => 'HomeController@index'
]);

Route::resource('accounts', 'AccountsController');
Route::resource('profile', 'ProfilesController');
Route::get('employees/export', ['as' => 'employees.export', 'uses' => 'EmployeesController@export']);
Route::resource('employees', 'EmployeesController');
Route::get('departments/export', ['as' => 'departments.export', 'uses' => 'DepartmentsController@export']);
Route::resource('departments', 'DepartmentsController');
Route::get('clients/export', ['as' => 'clients.export', 'uses' => 'ClientsController@export']);
Route::resource('clients', 'ClientsController');
Route::resource('forms', 'FormsController');
Route::get('rejectreasons/export', ['as' => 'rejectreasons.export', 'uses' => 'RejectReasonsController@export']);
Route::resource('rejectreasons', 'RejectReasonsController');
Route::get('/rfps/{id}/pdf', ['as' => 'rfps.pdf', 'uses' => 'PaymentRequestsController@pdf']);
Route::resource('rfps', 'PaymentRequestsController');
Route::resource('approval', 'ApprovalController', ['only' => ['index', 'show', 'edit', 'update']]);

/*
*
* Auuthenticated group
*
*/
Route::group(array('before' => 'auth'), function(){
	/*
	/ CSRF group
	*/
	Route::group(array('before' => 'csrf'), function(){
		
	});

	/*
	*
	* System Admin group
	*
	*/
	Route::group(array('before' => 'role'), function() {

		Route::group(array('prefix' => '/admin'), function() {
		});
	});

	/*
	/ Dashboard Index (GET)
	*/
	Route::get('/dashboard', [
		'as' => 'dashboard',
		'uses' => 'DashboardController@index'
	]);

	/*  Sign out (GET) */
	Route::get('/sign-out', [
		'as' => 'sessions.signout',
		'uses' => 'SessionsController@destroy'
	]);
});

/*
*
* Unauthenticated group
*
*/
Route::group(array('before' => 'guest'), function(){
	/*
	/ CSRF group
	*/
	Route::group(array('before' => 'csrf'), function(){

		/* Sign in (POST) */
		Route::post('/sign-in', [
			'as' => 'sessions.store',
			'uses' => 'SessionsController@store'
		]);
			
	});

	/* Sign in (GET) */
	Route::get('/sign-in', [
		'as' => 'sessions.create',
		'uses' => 'SessionsController@create'
	]);
});