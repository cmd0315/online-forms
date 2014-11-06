<?php namespace BCD\OnlineForms;

use BCD\OnlineForms\OnlineForm;
use BCD\OnlineForms\Rejection\FormRejectReason;
use BCD\OnlineForms\Rejection\RejectReason;
use BCD\OnlineForms\Rejection\RejectionHistory;

class OnlineFormRepository {

	/**
	* Persists the OnlineForm class
	*
	* @param OnlineForm $onlineForm
	*/
	public function save(OnlineForm $onlineForm) {
		return $onlineForm->save();
	}

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
		else {
			return date('y') . '-0001';
		}
	}

	/**
	* Return OnlineForm of current logged in user
	*
	* @return OnlineForm
	*/
	public function getCurrentUserForms() {
		return OnlineForm::where('created_by', Auth::user()->username);
	}

	/**
	* Return OnlineForm given their model type
	*
	* @param String $modelName
	* @return OnlineForm
	*/
	public function getUserFormByCategory($modelName) {
		return $this->getCurrentUserForms()->where('formable_type', $modelName)->orderBy('updated_at', 'ASC')->get(); 
	}

	/**
	* Return OnlineForm given their row id
	*
	* @param int $id
	* @return OnlineForm
	*/
	public function getFormByID($id) {
		return OnlineForm::where('id', $id)->firstOrFail();
	}

	/**
	* Return OnlineForm given their formable id
	*
	* @param int $id
	* @return OnlineForm
	*/
	public function getFormByFormableID($id) {
		return OnlineForm::where('formable_id', $id)->firstOrFail();
	}

	/**
	* Get all the reasons why a form can be rejected
	*
	* @param String
	* @return FormRejectReason
	*/
	public function getAllFormRejectReasons($formableType) {
		$dir = 'BCD\\';
		$dir .= $formableType; 
		$formRejectReasons = FormRejectReason::where('formable_type', $dir)->get();

		return $formRejectReasons;
	}

	/**
	* Get the reasons why a form can be rejected
	*
	* @param int $id
	* @return array
	*/
	public function getFormRejectReasons($id) {
		$rejectReasonArr = [];

		$formRejectReasons = OnlineForm::where('id', $id)->firstOrFail()->formRejectReasons;

		foreach($formRejectReasons as $fRR) {
			$rejectReason = RejectReason::where('id', $fRR->reject_reason_id)->firstOrFail();

			array_push($rejectReasonArr, $rejectReason); 
		}

		return $rejectReasonArr;

	}

	/**
	* Return the reasons why the form was rejected
	*
	* @param int $id
	* @return array
	*/
	public function getWhyRejected($id) {
		$whyRejectedArr = [];

		$onlineForm = $this->getFormByID($id);

		if($onlineForm->departmentRejected()) {
			$whyRejected = RejectionHistory::where('form_id', $id)->get();

			foreach($whyRejected as $wR) {
				array_push($whyRejectedArr, $wR->reason_id);
			}
		}

		return $whyRejectedArr;
	}

}