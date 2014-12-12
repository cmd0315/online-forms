<?php

	class RejectReasonSeeder extends BCDSeeder {

		protected $table = "reject_reasons";

		public function getData() {
			return [
				['reason' => 'Incomplete attachment', 'form_type' => 'Payment Request', 'process_type' => 'Department Approval', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['reason' => 'Not enough funds', 'form_type' => 'Payment Request', 'process_type' => 'Department Approval', 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		} 
	}