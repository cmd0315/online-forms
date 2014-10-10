<?php namespace BCD\Departments\Registration;

use Laracasts\Commander\CommandHandler;
use BCD\Departments\DepartmentRepository;
use BCD\Departments\Department;

class AddDepartmentCommandHandler implements CommandHandler {

	/**
	* @var DepartmentRepository
	*/
	protected $departmentRepository;

	/**
	* Constructor
	*
	* @var DepartmentRepository $departmentRepository
	*
	*/
	function __construct(DepartmentRepository $departmentRepository) {
		$this->departmentRepository = $departmentRepository;
	}

	/**
	*
	* Handle the command
	*
	* @param AddDepartmentCommand $command
	* @return mixed
	*
	*/
	public function handle($command) {
		$department = Department::register(
			$command->department_id, $command->department_name
		);

		$this->departmentRepository->save($department);

		return $department;
	}
}