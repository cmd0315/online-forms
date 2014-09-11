<?php

	class EmployeeSeeder extends BCDSeeder {

		protected $table = "employees";

		public function getData() {
			return [
				['username' => 'crist_lopez', 'first_name' => 'Crist Anthony', 'middle_name' => 'Ma', 'last_name' => 'Lopez', 'email' => 'crist.lopez@bcdpinpoint.com', 'department_id' => 'D-IT', 'position' => '2'],
				['username' => 'charisse_dalida', 'first_name' => 'Charisse May', 'middle_name' => 'Matutina', 'last_name' => 'Dalida', 'email' => 'charissemay.dalida@bcdpinpoint.com', 'department_id' => 'D-DIGI', 'position' => '1']
			];
		} 
	}