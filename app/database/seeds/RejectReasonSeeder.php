<?php

	class RejectReasonSeeder extends BCDSeeder {

		protected $table = "reject_reasons";

		public function getData() {
			return [
				['reason' => 'Incomplete attachment', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['reason' => 'Not enough funds', 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		} 
	}