<?php

	class FormCategorySeeder extends BCDSeeder {

		protected $table = "form_categories";

		public function getData() {
			return [
				['name' => 'Leave of Absence', 'alias' => 'lob', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Overtime Authorization', 'alias' => 'ota', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Official Business Request', 'alias' => 'obr', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Petty Cash Voucher', 'alias' => 'pcv', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Check Voucher', 'alias' => 'cev', 'created_at' => new DateTime, 'updated_at' => new DateTime],
				['name' => 'Payment Request', 'alias' => 'rfp', 'created_at' => new DateTime, 'updated_at' => new DateTime],
			];
		} 
	}