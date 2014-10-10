<?php

	class AccountRoleSeeder extends BCDSeeder {

		protected $table = "account_role";

		public function getData() {
			return [
				['account_id' => '1', 'role_id' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['account_id' => '2', 'role_id' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		} 
	}