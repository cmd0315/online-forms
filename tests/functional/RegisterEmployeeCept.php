<?php 
$I = new FunctionalTester($scenario);
$I->amLoggedAs(['username' => 'crist_lopez', 'password' => '123456']);
$I->seeAuthentication();
$I->wantTo('create an account for a BCD employee');

$username = 'dickie_soriano';
$password = 'testing1234';
$password_again = 'testing1234';
$first_name = 'J. Richards';
$middle_name = 'Testing';
$last_name = 'Soriano';
$birthdate = '07/04/1965';
$address = 'Greater Manila, Quezon City';
$email = 'dickie_soriano@bcdpinpoint.com';
$mobile = '09234545432';
$department = 'D-DIGI';

$I->amOnPage('/employees/create');
$I->see('Add Employee Record');
$I->fillField('username', $username);
$I->fillField('password', $password);
$I->fillField('password_again', $password);
$I->fillField('first_name', $first_name);
$I->fillField('middle_name', $middle_name);
$I->fillField('last_name', $last_name);
$I->fillField('birthdate', $birthdate);
$I->fillField('address', $address);
$I->fillField('email', $email);
$I->fillField('mobile', $mobile);
$I->fillField('department', $department);
$I->click('Submit');

$I->see('Employee account successfully created!');
$I->seeRecord('accounts', ['username' => 'dickie_soriano']);
$I->seeRecord('employees', ['username' => 'dickie_soriano']);