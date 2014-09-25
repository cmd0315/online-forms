<?php 
$I = new FunctionalTester($scenario);
$I->amLoggedAs(['username' => 'crist_lopez', 'password' => 'testing1234']);
$I->seeAuthentication();
$I->wantTo('change my account password');


$I->amOnPage('/dashboard');
$I->click('Profile');
$I->see('My Profile');
$I->click('(Change Password)');
$I->see('Account Details');

$I->fillField('old_password', 'testing1234');
$I->fillField('password', 'testing123');
$I->fillField('password', 'testing123');
$I->click('Submit');

$password = Hash::make('testing123');
$I->seeRecord('accounts', ['username' => 'crist_lopez' ,'password' => $password]);

