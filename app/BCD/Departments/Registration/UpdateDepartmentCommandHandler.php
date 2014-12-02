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
	* Handles the command
	*
	* @param UpdateDepartmentCommand $command
	* @return Department
	*/
	public function handle($command) {
		$department = $this->departmentRepository->getDepartmentByID($command->id);

		$updateDepartment = "";
		
		//Check if model exists
		if($department) {
			//Update department_id and department_name
			$department->department_id = $command->department_id;
			$department->department_name = $command->department_name;
			$updateDepartment = $this->departmentRepository->save($department);

			//Check if saving of department is successful and if department_head as input exists
			if($updateDepartment && $command->department_head) {
				$previousHead = $department->employees()->where('position', '=', '1')->first();
				/**Check if there is already an employee who is heading the department, 
				*if yes change his position to member employee
				*/
				if($previousHead) {
					$previousHead->position = 0;
					$demotePreviousHead = $this->employeeRepository->save($previousHead);
				}

				//Chenge the chosen employee position to head employee and save
				$nextHead = $department->employees()->where('username', $command->department_head)->firstOrFail();
				$nextHead->position = 1;
				$promoteMember = $this->employeeRepository->save($nextHead);
			}
		}
		return $department;
	}
}