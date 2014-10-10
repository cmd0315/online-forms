<?php

	class RoleSeeder extends BCDSeeder {

		protected $table = "roles";

		public function getData() {
			return [
				['name' => 'Member', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'System Administrator', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Owner', 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		} 
	}