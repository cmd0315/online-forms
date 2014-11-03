<?php

	class EmployeeSeeder extends BCDSeeder {

		protected $table = "employees";

		public function getData() {
			return [
				['username' => 'crist_lopez', 'first_name' => 'Crist Anthony', 'middle_name' => 'Ma', 'last_name' => 'Lopez', 'birthdate' => '1986-11-01', 'address' => 'Caloocan', 'email' => 'crist.lopez@bcdpinpoint.com', 'mobile' => '09272992329', 'department_id' => 'D-IT', 'position' => '0'],
				['username' => 'charisse_dalida', 'first_name' => 'Charisse May', 'middle_name' => 'Matutina', 'last_name' => 'Dalida', 'birthdate' => '1992-03-15', 'address' => 'Meycauayan, Bulacan', 'email' => 'charissemay.dalida@bcdpinpoint.com', 'mobile' => '09087312200', 'department_id' => 'D-DIGI', 'position' => '1'],
				['username' => 'nerissa_viloria', 'first_name' => 'Nerissa', 'middle_name' => 'Montano', 'last_name' => 'Viloria', 'birthdate' => '1967-01-31', 'address' => 'Quezon City', 'email' => 'nerissa.viloria@bcdpinpoint.com', 'mobile' => '09178850063', 'department_id' => 'D-HR', 'position' => '1'],
				['username' => 'may_tunque', 'first_name' => 'May', 'middle_name' => 'De Los Santos', 'last_name' => 'Tunque', 'birthdate' => '1970-09-17', 'address' => 'Morong, Rizal', 'email' => 'may.tunque@bcdpinpoint.com', 'mobile' => '09399266382', 'department_id' => 'D-FINA', 'position' => '1']
			];
		} 
	}