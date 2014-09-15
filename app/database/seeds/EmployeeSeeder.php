<?php

	class EmployeeSeeder extends BCDSeeder {

		protected $table = "employees";

		public function getData() {
			return [
				['username' => 'crist_lopez', 'first_name' => 'Crist Anthony', 'middle_name' => 'Ma', 'last_name' => 'Lopez', 'birthdate' => '1986-11-01', 'address' => 'Caloocan', 'email' => 'crist.lopez@bcdpinpoint.com', 'department_id' => 'D-IT', 'position' => '2'],
				['username' => 'charisse_dalida', 'first_name' => 'Charisse May', 'middle_name' => 'Matutina', 'last_name' => 'Dalida', 'birthdate' => '1992-03-15', 'address' => 'Meycauayan, Bulacan', 'email' => 'charissemay.dalida@bcdpinpoint.com', 'department_id' => 'D-DIGI', 'position' => '1']
			];
		} 
	}