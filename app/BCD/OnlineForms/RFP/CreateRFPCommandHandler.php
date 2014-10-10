<?php namespace BCD\OnlineForms\RFP;

use Laracasts\Commander\CommandHandler;
use BCD\RequestForPayments\RequestForPayment;
use BCD\OnlineForms\OnlineForm;
use BCD\RequestForPayments\RequestForPaymentRepository;
use BCD\OnlineForms\OnlineFormRepository;
class CreateRFPCommandHandler implements CommandHandler {

	/**
	* @var OnlineFormRepository $onlineFormRepository
	*/
	protected $onlineFormRepository;

	/**
	* @var RequestForPaymentRepository $rfpRepository
	*/
	protected $rfpRepository;

	public function __construct(OnlineFormRepository $onlineFormRepository, RequestForPaymentRepository $rfpRepository) {

		$this->onlineFormRepository = $onlineFormRepository;
		$this->rfpRepository = $rfpRepository;
	}

	/**
	* Handles the command.
	*
	* @param CreateRFPCommand $command
	*/
	public function handle($command) {
		$onlineForm = OnlineForm::addForm(
			$command->form_num, 'rfp', $command->requestor	
		);

		$rfp = RequestForPayment::createRequest(
			$command->form_num, $command->payee_firstname, $command->payee_middlename, $command->payee_lastname, $command->date_requested, $command->particulars, $command->total_amount, $command->client_id, $command->check_num, $command->department_id, $command->date_needed, $command->approved_by
		);
		
		$this->onlineFormRepository->save($onlineForm);

		$this->rfpRepository->save($rfp);

		return $rfp;
	}
}