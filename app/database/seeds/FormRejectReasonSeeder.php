<?php

	class FormRejectReasonSeeder extends BCDSeeder {

		protected $table = "form_reject_reasons";

		public function getData() {
			return [
				['formable_type' => 'BCD\RequestForPayments\RequestForPayment', 'reject_reason_id' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['formable_type' => 'BCD\RequestForPayments\RequestForPayment', 'reject_reason_id' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		} 
	}