<?php namespace BCD\OnlineForms\PaymentRequests\Commands;

class EditPaymentRequestCommand {

	/**
	* @var mixed
	*/
	public $form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $requestor, $department_id, $date_needed;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $requestor, $department_id, $date_needed) {

		$this->form_num = $form_num;
		$this->payee_firstname = $payee_firstname;
		$this->payee_middlename = $payee_middlename;
		$this->payee_lastname = $payee_lastname;
		$this->date_requested = $date_requested;
		$this->particulars = $particulars;
		$this->total_amount = $total_amount;
		$this->client_id = $client_id;
		$this->check_num = $check_num;
		$this->requestor = $requestor;
		$this->department_id = $department_id;
		$this->date_needed = $date_needed;
	}
}

