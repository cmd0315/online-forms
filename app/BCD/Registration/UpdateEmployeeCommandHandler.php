<?php namespace BCD\Registration;

use Laracasts\Commander\CommandHandler;
use BCD\Employees\EmployeeRepository;

class UpdateEmployeeCommandHandler implements CommandHandler {

	/**
	* @var EmployeeRepository $employeeRepository
	*/
	protected $employeeRepository;

	function __construct(EmployeeRepository $employeeRepository) {
		$this->employeeRepository = $employeeRepository;
	}

	/**
	*
	* Handle the command
	*
	* @param UpdateEmployeeCommand $command
	* @return mixed
	*
	*/
	public function handle($command) {
		$update = $this->employeeRepository->update(
			$command->username, $command->first_name, $command->middle_name, $command->last_name,
			$command->birthdate, $command->address, $command->email, $command->mobile, $command->department_id
		);

		return $update;
	}
}