<?php
/* Home */
Route::get('/',[
	'as' => 'home',
	'uses' => 'HomeController@index'
]);



Route::resource('accounts', 'AccountsController');
Route::resource('profile', 'ProfilesController');
Route::resource('employees', 'EmployeesController');
Route::resource('departments', 'DepartmentsController');

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