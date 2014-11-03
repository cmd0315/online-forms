<?php namespace BCD\RequestForPayments;

use BCD\OnlineForms\OnlineForm;
use BCD\RequestForPayments\RequestForPayment;

class RequestForPaymentRepository {
	
	/**
	* Persists an RequestForPayment
	*
	* @param RequestForPayment $rfp
	*/
	public function save(RequestForPayment $rfp) {
		return $rfp->save();
	}

	public function getUserForms($currentUser) {
		//return OnlineForm::currentUserForms($currentUser->username)->formsByCategory('BCD\RequestForPayments\RequestForPayment')->paginate(5);

		return RequestForPayment::userForms($currentUser)->paginate(5);
	}

	public function getFormByFormNum($formNum) {
		return RequestForPayment::where('form_num', $formNum)->firstOrFail();
	}
	
}