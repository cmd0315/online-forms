<?php namespace BCD\OnlineForms\PaymentRequests\Commands;

use Laracasts\Commander\CommandHandler;
use BCD\OnlineForms\PaymentRequests\PaymentRequest;
use BCD\OnlineForms\PaymentRequests\PaymentRequestRepository;

class CreatePaymentRequestCommandHandler implements CommandHandler {

	/**
	* @var PaymentRequestRepository $paymentRequestRepo
	*/
	protected $paymentRequestRepo;

	/**
	* Constructor
	*
	* PaymentRequestRepository $paymentRequestRepo
	*/
	public function __construct(PaymentRequestRepository $paymentRequestRepo) {

		$this->paymentRequestRepo = $paymentRequestRepo;
	}

	/**
	* Handles the command.
	*
	* @param CreatePaymentRequestCommand $command
	* @return PaymentRequest
	*/
	public function handle($command) {
		$paymentRequest = $this->paymentRequestRepo->create(
			$command->form_num, $command->payee_firstname, $command->payee_middlename, $command->payee_lastname, $command->date_requested, $command->particulars, $command->total_amount, $command->client_id, $command->check_num, $command->date_needed
		);
		
		if($this->paymentRequestRepo->save($paymentRequest)) {
			$paymentRequest->onlineForm()->create(['created_by' => $command->requestor, 'updated_by' => $command->requestor, 'department_id' => $command->department_id]);

			return $paymentRequest;

		}

	}
}