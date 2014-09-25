<?php namespace BCD\Employees;

use BCD\Employees\Account;
use Hash;

class AccountRepository {
	/**
	* Persists an Account
	*
	* @param Account $account
	*/
	public function save(Account $account) {
		return $account->save();
	}

	/**
	* Get account based on username
	*
	* @param String $username
	*/
	public function find($username) {
		return Account::whereUsername($username)->firstOrFail();
	}

	/**
	* Soft delete employee account
	*
	* @param String $username
	*/
	public function remove($username) {
		$account = Account::whereUsername($username)->firstOrFail();

		return $account->delete();
	}
}