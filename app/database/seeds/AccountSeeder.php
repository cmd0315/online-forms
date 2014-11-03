<?php

	class AccountSeeder extends BCDSeeder {

		protected $table = "accounts";

		public function getData() {
			return [
				['username' => 'crist_lopez', 'password' => Hash::make('testing1234'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['username' => 'charisse_dalida', 'password' => Hash::make('testing123'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['username' => 'nerissa_viloria', 'password' => Hash::make('testing123'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['username' => 'may_tunque', 'password' => Hash::make('testing123'), 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		}
	}