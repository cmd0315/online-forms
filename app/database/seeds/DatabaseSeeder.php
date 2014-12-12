<?php

class DatabaseSeeder extends Seeder {


	protected $tables = [
		'accounts',
		'employees',
		'departments',
		'roles',
		'account_role',
		'clients',
		'onlineforms',
		'reject_reasons',
		'prs'
	];

	protected $seeders = [
		'AccountSeeder',
		'EmployeeSeeder',
		'DepartmentSeeder',
		'RoleSeeder',
		'AccountRoleSeeder',
		'ClientSeeder',
		'RejectReasonSeeder'
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->cleanDatabase();
		
		foreach($this->seeders as $seederClass) {
			$this->call($seederClass);
		}
	}

	/*
	* Clean database to prepare for seed generation
	*/
	private function cleanDatabase() {

		DB::statement('SET FOREIGN_KEY_CHECKS = 0'); //disregard foreign key rules

		foreach($this->tables as $table) {
			DB::table($table)->truncate();
		}

		DB::statement('SET FOREIGN_KEY_CHECKS = 1'); //enable foreign key rules
	}

}
