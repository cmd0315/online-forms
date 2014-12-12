<?php

class CustomValidator {

	public function lesserThan($field, $value, $parameters){
		if($value > $field) {
		   return true;
		}

		return false;
	}
}