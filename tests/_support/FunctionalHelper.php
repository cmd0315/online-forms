<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Laracasts\TestDummy\Factory as TestDummy;
use Illuminate\Support\Facades\Hash;

class FunctionalHelper extends \Codeception\Module
{
	public function signIn() {
		$username = 'crist_lopez2';
		$password = 'testing1234';

		 $this->haveAnAccount([
            'username' => $username,
            'password' => Hash::make($password)
        ]);

		$I = $this->getModule('Laravel4');
		$I->amOnPage('/sign-in');

		$I->fillField('username', $username);
		$I->fillField('password', $password);
		$I->click('Sign in');
	}
	
	/**
	* Create an instance of the Account model
	*
	* @param $overrides
	*/
	public function haveAnAccount($overrides = []) {
		return $this->have('BCD\Employees\Account', $overrides);
	}

	/**
	* Create an instance of the specified model 
	*
	* @param $model
	* @param $overrides
	*/
	public function have($model, $overrides = []) {
		return TestDummy::create($model, $overrides);
	}

}