<?php

abstract class BCDSeeder extends Seeder {
	
	public function run() {

		if(!isset($this->table)) {
			throw new Exception('No table specified');
		}

		if(method_exists(get_class(), 'getData')) {
			throw new Exception('No data specified');
		}

		DB::table($this->table)->insert($this->getData());
	}
}