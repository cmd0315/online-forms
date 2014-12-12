<?php namespace BCD\OnlineForms\PaymentRequests;

class PaymentRequestRepository {

	/**
	* Persists a PaymentRequest
	*
	* @param mixed
	* @return PaymentRequest $paymentRequest
	*/
	public function create($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $date_needed) {

		$paymentRequest = PaymentRequest::createRequest($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $date_needed);

		return $paymentRequest;
	}

	/**
	* Persists a PaymentRequest
	*
	* @param PaymentRequest $paymentRequest
	* @return PaymentRequest
	*/
	public function save(PaymentRequest $paymentRequest) {
		return $paymentRequest->save();
	}

	/**
	* Return all records including those that have been soft deleted 
	*
	*
	* @return PaymentRequest
	*/
	public function all() {

		return PaymentRequest::withTrashed();
	}

	/**
	* Get record by id
	*
	* @param int $id
	* @return PaymentRequest
	*/
	public function findByID($id) {

		return $this->all()->where('id', $id)->firstOrFail();
	}

	/**
	* Return all forms relating to the specified user
	*
	* @param Account $currentUser
	* @param int $maxRowPerPage
	* @return PaymentRequest
	*/
	public function getUserForms($currentUser, $maxRowPerPage) {
		return $this->all()->userForms($currentUser)->paginate($maxRowPerPage);
	}

	/**
	* Return form with specified form number
	*
	* @param String $formNum
	* @return PaymentRequest
	*/
	public function getFormByFormNum($formNum) {
		return $this->all()->where('form_num', $formNum)->firstOrFail();
	}
}