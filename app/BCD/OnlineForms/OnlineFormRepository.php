<?php namespace BCD\OnlineForms;

use BCD\OnlineForms\OnlineForm;
use BCD\OnlineForms\Rejection\FormRejectReason;
use BCD\OnlineForms\Rejection\RejectReason;
use BCD\OnlineForms\Rejection\RejectionHistory;

use BCD\RequestForPayments\RequestForPayment;

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
	* Return all instance of the form including the trashed
	*
	* @return OnlineForm
	*/
	public function getAll() {
		return OnlineForm::withTrashed();
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
		return $this->getAll()->where('created_by', Auth::user()->username);
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
		return $this->getAll()->where('id', $id)->firstOrFail();
	}

	/**
	* Return OnlineForm given the form number
	*
	* @param String $formNum
	* @return OnlineForm
	*/
	public function getFormByFormNum($formNum) {
		return $this->getAll()->where('form_num', $formNum)->firstOrFail();
	}

	/**
	* Return OnlineForm given their formable id
	*
	* @param int $id
	* @return OnlineForm
	*/
	public function getFormByFormableID($id) {
		return $this->getAll()->where('formable_id', $id)->firstOrFail();
	}

	public function getFormType($id) {
		$onlineForm = $this->getFormByFormableID($id);

		$formType = explode('\\', $onlineForm->formable_type);
		$formType = $formType[2];

		return $formType;
	}

	public function getFormNum($id) {
		$formType = $this->getFormType($id);

		$onlineForm = $this->getFormByID($id);

		if($onlineForm->isRecognized($formType)) {
			if($formType == "RequestForPayment") {
				return RequestForPayment::where('id', $id)->pluck('form_num');
			}

		}
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
	* Get the reasons why a form can be rejected by a department
	*
	* @param int $id
	* @return array
	*/
	public function getFormDepartmentRejectReasons($id) {
		$formRejectReasonArr = [];

		$formRejectReasons = OnlineForm::where('id', $id)->firstOrFail()->formRejectReasons;

		foreach($formRejectReasons as $fRR) {
			if($fRR->process_type < 1) {
				array_push($formRejectReasonArr, $fRR); 

			}
		}

		return $formRejectReasonArr;

	}

	/**
	* Get the reasons why a form can be rejected by a receiver
	*
	* @param int $id
	* @return array
	*/
	public function getFormReceiveRejectReasons($id) {
		$formRejectReasonArr = [];

		$formRejectReasons = $this->getFormByID($id)->formRejectReasons;

		foreach($formRejectReasons as $fRR) {
			if($fRR->process_type >= 1) {
				array_push($formRejectReasonArr, $fRR); 

			}
		}

		return $formRejectReasonArr;

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

		if($onlineForm->departmentRejected() || $onlineForm->receiverRejected()) {
			$whyRejected = RejectionHistory::where('form_id', $id)->get();

			foreach($whyRejected as $wR) {
				array_push($whyRejectedArr, $wR->form_reject_reason_id);
			}
		}

		return $whyRejectedArr;
	}

	/**
	* Soft delete an online form entity
	*
	* @param int $id
	*/
	public function closeRequest($id) {
		return $this->getFormByID($id)->delete();
	}

}