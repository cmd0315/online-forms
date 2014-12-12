<?php namespace BCD\OnlineForms;

use BCD\OnlineForms\OnlineForm;

class OnlineFormRepository {

	/**
	* Generate form number specifi for a particular type of form
	*
	* @param String $formType
	* @return String
	*/
	public function generateFormNum($formType) {
		$lastFormNum = OnlineForm::where('formable_type', $formType)->orderBy('id', 'DESC')->pluck('formable_id');

		if($lastFormNum) {
			$num = sprintf('%04d', $lastFormNum);

			$generatedFormNum = date('y') . '-' . sprintf('%04d', $num + 1);

			return $generatedFormNum;
		}
		
		return date('y') . '-0001';
	}

	/**
	* Persists a OnlineForm
	*
	* @param OnlineForm $onlineForm
	*/
	public function save(OnlineForm $onlineForm) {
		return $onlineForm->save();
	}

	/**
	* Return all records including those that have been soft deleted 
	*
	*
	* @return OnlineForm
	*/
	public function all() {

		return OnlineForm::withTrashed();
	}

	/**
	* Get record by id
	*
	* @param int $id
	* @return OnlineForm
	*/
	public function findByID($id) {

		return $this->all()->where('id', $id)->firstOrFail();
	}

}