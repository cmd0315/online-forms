<?php namespace BCD\Employees\Registration;

use Laracasts\Commander\CommandHandler;
use BCD\Employees\Account;
use BCD\Employees\AccountRepository;
use BCD\Employees\Employee;
use BCD\Employees\EmployeeRepository;

class RemoveEmployeeCommandHandler implements CommandHandler {

	/**
	* @var AccountRepository $accountRepository
	*/
	public $accountRepository;

	/**
	* @var EmployeeRepository $employeeRepository
	*/
	public $employeeRepository;

	/**
	* Constructor
	*
	* @param AccountRepository $accountRepository
	* @param EmployeeRepository @employeeRepository
	*/
	function __construct(AccountRepository $accountRepository, EmployeeRepository $employeeRepository) {
		$this->accountRepository = $accountRepository;
		$this->employeeRepository = $employeeRepository;
	}

	/**
	* Command handler
	*
	* @param RemoveEmployeeCommand
	* @return Employee
	*/
	public function handle($command) {
		$accountDelete = $this->accountRepository->remove($command->username);
		$employeeDelete = $this->employeeRepository->remove($command->username);

		return $employeeDelete;
	}
}