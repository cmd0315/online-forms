<?php namespace BCD\Employees;

use BCD\Employees\Account;

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
	* @return Account
	*/
	public function find($username) {
		return Account::withTrashed()->whereUsername($username)->firstOrFail();
	}

	/**
	* Soft delete employee account
	*
	* @param String $username
	* @return Account
	*/
	public function remove($username) {
		$account = Account::withTrashed()->whereUsername($username)->firstOrFail();

		return $account->delete();
	}

	/**
	* Restore employee account
	*
	* @param String $username
	* @return Account
	*/
	public function restore($username) {
		$account = $this->find($username);

		return $account->restore();
	}
}