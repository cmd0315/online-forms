<?php

	class DepartmentSeeder extends BCDSeeder {

		protected $table = "departments";

		public function getData() {
			return [
				['department_id' => 'D-BCD', 'department_name' => 'BCD', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['department_id' => 'D-IT', 'department_name' => 'IT', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['department_id' => 'D-DIGI', 'department_name' => 'Digital', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['department_id' => 'D-HR', 'department_name' => 'HR', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['department_id' => 'D-FINA', 'department_name' => 'Finance', 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		}
	}