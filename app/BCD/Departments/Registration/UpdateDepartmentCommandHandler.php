<?php namespace BCD\Departments\Registration;

use Laracasts\Commander\CommandHandler;
use BCD\Departments\DepartmentRepository;
use BCD\Employees\EmployeeRepository;

class UpdateDepartmentCommandHandler implements CommandHandler {
	/**
	* @var DepartmentRepository $departmentRepository
	*/
	protected $departmentRepository;

	/**
	* @var EmployeeRepository $employeeRepository
	*/
	protected $employeeRepository;

	/**
	* @var DepartmentRepository $departmentRepository
	* @var EmployeeRepository $employeeRepository
	*/
	function __construct(DepartmentRepository $departmentRepository, EmployeeRepository $employeeRepository) {
		$this->departmentRepository = $departmentRepository;
		$this->employeeRepository = $employeeRepository;
	}

	public function handle($command) {
		$department = $this->departmentRepository->getDepartmentByID($command->id);

		$updateDepartment = "";
		
		if($department) {
			$department->department_id = $command->department_id;
			$department->department_name = $command->department_name;
			$updateDepartment = $this->departmentRepository->save($department);

			if($updateDepartment) {
				$previousHead = $department->employees()->where('position', '=', '1')->first();
				if($previousHead) {
					$previousHead->position = 0;
					$demotePreviousHead = $this->employeeRepository->save($previousHead);
				}

				$nextHead = $department->employees()->where('username', $command->department_head)->firstOrFail();

				$nextHead->position = 1;

				$promoteMember = $this->employeeRepository->save($nextHead);
			}
		}
		
		return $updateDepartment;
	}
}