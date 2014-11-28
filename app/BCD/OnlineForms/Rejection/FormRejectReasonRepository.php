<?php namespace BCD\OnlineForms\Rejection;

use BCD\OnlineForms\Rejection\FormRejectReason;

class FormRejectReasonRepository {

	/**
	* Persists the FormRejectReason class
	*
	* @param FormRejectReason $formRejectReason
	*/
	public function save(FormRejectReason $formRejectReason) {
		return $formRejectReason->save();
	}

	/**
	* Return all form reject reasons given the formable_type
	*
	* @param String
	* @return FormRejectReason
	*/
	public function getFormRejectReason($formableType) {

		return FormRejectReason::where('formable_type', $formableType)->get();
	}

	/**
	* Return all form reject reasons given the reject reason id
	*
	* @param int
	* @return FormRejectReason
	*/
	public function getReasonByRejectByID($id) {

		return FormRejectReason::where('reject_reason_id', $id)->get();
	}

	public function remove($formableType, $rejectReasonID, $processType) {
		return FormRejectReason::where('reject_reason_id', $rejectReasonID)->where('formable_type', $formableType)->where('process_type', $processType)->delete();
	}

}