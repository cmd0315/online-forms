<?php namespace BCD\Employees\Registration;

use Laracasts\Commander\CommandHandler;
use BCD\Employees\Account;
use BCD\Employees\AccountRepository;
use BCD\Employees\Employee;
use BCD\Employees\EmployeeRepository;

class RestoreEmployeeCommandHandler implements CommandHandler {

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
	* @param RestoreEmployeeCommand
	* @return Employee
	*/
	public function handle($command) {
		$accountRestore = $this->accountRepository->restore($command->username);
		$employeeRestore = $this->employeeRepository->restore($command->username);

		return $employeeRestore;
	}
}