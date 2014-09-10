<?php

Route::get('/', function()
{
	return View::make('account.forms.payment-request');
});
