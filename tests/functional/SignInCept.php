<?php 

$I = new FunctionalTester($scenario);

$I->am('a BCD Online Forms website member');
$I->wantTo('login to BCD Online Forms account');

$I->signIn();

$I->seeInCurrentUrl('/dashboard');
$I->see('Dashboard');