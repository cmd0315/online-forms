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
		return OnlineForm::with('paymentRequest')->currentUserForms($currentUser)->formsByCategory('rfp')->paginate(5);
	}
	
}