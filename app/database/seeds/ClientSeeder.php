<?php

	class ClientSeeder extends BCDSeeder {

		protected $table = 'clients';

		public function getData() {
			
			return [
				['client_id' => 'BCD', 'client_name' => 'BCD Pinpoint', 'address' => 'Unit 507 Continental Court Condominium, 47 Annapolis St, Greenhills, San Juan', 'cp_first_name' => 'J. Richard', 'cp_middle_name' => '', 'cp_last_name' => 'Soriano', 'email' => 'dickie.soriano@bcdpinpoint.com', 'mobile' => '09178905574', 'telephone' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		}
	}