<?php namespace BCD\Departments\Registration;

use Laracasts\Commander\CommandHandler;
use BCD\Departments\DepartmentRepository;
use BCD\Employees\EmployeeRepository;

class RemoveDepartmentCommandHandler implements CommandHandler {
	/**
	* @var DepartmentRepository
	*/
	protected $departmentRepository;

	/**
	* @var EmployeeRepository
	*/
	protected $employeeRepository;

	/**
	* Constructor
	*
	* @var DepartmentRepository $departmentRepository
	* @var EmployeeRepository $employeeRepository
	*/
	function __construct(DepartmentRepository $departmentRepository, EmployeeRepository $employeeRepository) {
		$this->departmentRepository = $departmentRepository;
		$this->employeeRepository = $employeeRepository;
	}

	/**
	* Handles the command.
	*
	* @param RemoveDepartmentCommand $command
	* @return Department
	*/
	public function handle($command) {
		$departmentRemove = $this->departmentRepository->remove($command->department_id);

		if($departmentRemove) {
			$employees = $this->employeeRepository->getEmployeesByDepartment($command->department_id);

			if($employees) {
				foreach($employees as $employee) {
					$employee->position = 0; //assign as member employee
					$employee->department_id = 'D-BCD'; //assign to default department
					$employee->save();
				}
			}
		}

		return $departmentRemove;
	}
}