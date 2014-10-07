<?php namespace BCD\DepartmentRegistration;

use Laracasts\Commander\CommandHandler;
use BCD\Departments\DepartmentRepository;

class RemoveDepartmentCommandHandler implements CommandHandler {
	/**
	* @var DepartmentRepository
	*/
	protected $departmentRepository;

	/**
	* Constructor
	*
	* @var DepartmentRepository $departmentRepository
	*/
	function __construct(DepartmentRepository $departmentRepository) {
		$this->departmentRepository = $departmentRepository;
	}

	/**
	* Handles the command.
	*
	* RemoveDepartmentCommand $command
	*/
	public function handle($command) {
		$employeeRemove = $this->departmentRepository->remove($command->department_id);

		if($employeeRemove) {
			//disassociate members
			return $employeeRemove;
		}
	}
}