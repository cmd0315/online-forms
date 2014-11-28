<?php namespace BCD\OnlineForms\RFP;

use Laracasts\Commander\CommandHandler;
use BCD\RequestForPayments\RequestForPayment;
use BCD\RequestForPayments\RequestForPaymentRepository;
class CreateRFPCommandHandler implements CommandHandler {

	/**
	* @var RequestForPaymentRepository $rfpRepository
	*/
	protected $rfpRepository;

	/**
	* Constructor
	*
	* RequestForPaymentRepository $rfpRepository
	*/
	public function __construct(RequestForPaymentRepository $rfpRepository) {

		$this->rfpRepository = $rfpRepository;
	}

	/**
	* Handles the command.
	*
	* @param CreateRFPCommand $command
	* @return RequestForPayment
	*/
	public function handle($command) {
		$rfp = RequestForPayment::createRequest(
			$command->form_num, $command->payee_firstname, $command->payee_middlename, $command->payee_lastname, $command->date_requested, $command->particulars, $command->total_amount, $command->client_id, $command->check_num, $command->date_needed
		);
		
		$this->rfpRepository->save($rfp);

		$rfp->onlineForm()->create(['created_by' => $command->requestor, 'updated_by' => $command->requestor, 'department_id' => $command->department_id]);

		return $rfp;
	}
}