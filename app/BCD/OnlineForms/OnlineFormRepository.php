<?php namespace BCD\OnlineForms;

use BCD\OnlineForms\FormCategory;
use BCD\OnlineForms\OnlineForm;

class OnlineFormRepository {

	/**
	* Persists the OnlineForm class
	*
	* @param OnlineForm $onlineForm
	* @return 
	*/
	public function save(OnlineForm $onlineForm) {
		return $onlineForm->save();
	}

	public function generateFormNum() {
		$lastFormNum = OnlineForm::orderBy('id', 'DESC')->pluck('form_num');

		if($lastFormNum) {
			$oldFormNum = explode('-', $lastFormNum);

			$num = sprintf('%04d', $oldFormNum[1]);

			$generatedFormNum = date('y') . '-' . sprintf('%04d', $num + 1);

			return $generatedFormNum;
		}
		else {
			return date('y') . '-0001';
		}
	}

	public function getCurrentUserForms() {
		return OnlineForm::where('username', Auth::user()->username);
	}

	public function getUserFormByCategory($category) {
		$category_id = FormCategory::where('alias', $category)->pluck('id');

		return $this->getCurrentUserForms()->where('category_id', $category_id)->orderBy('updated_at', 'DESC')->get(); 
	}
}