<?php

	class ClientSeeder extends BCDSeeder {

		protected $table = 'clients';

		public function getData() {
			
			return [
				['client_id' => 'BCD', 'client_name' => 'BCD Pinpoint', 'created_at' => new DateTime, 'updated_at' => new DateTime]
			];
		}
	}