<?php namespace BCD\OnlineForms\RFP;

use Laracasts\Commander\CommandHandler;
use BCD\RequestForPayments\RequestForPayment;
use BCD\RequestForPayments\RequestForPaymentRepository;
use BCD\OnlineForms\OnlineFormRepository;
class EditRFPCommandHandler implements CommandHandler {

	/**
	* @var OnlineFormRepository $onlineFormRepository
	*/
	protected $onlineFormRepository;

	/**
	* @var RequestForPaymentRepository $rfpRepository
	*/
	protected $rfpRepository;

	/**
	* Constructor
	*
	* @param RequestForPaymentRepository $rfpRepository
	* @param OnlineFormRepository $onlineFormRepository
	*/
	public function __construct(RequestForPaymentRepository $rfpRepository, OnlineFormRepository $onlineFormRepository) {

		$this->rfpRepository = $rfpRepository;
		$this->onlineFormRepository = $onlineFormRepository;
	}

	/**
	* Handles the command.
	*
	* @param EditRFPCommand $command
	* @return RequestForPayment
	*/
	public function handle($command) {
		$rfp = $this->rfpRepository->getFormByFormNum($command->form_num);
		
		if($rfp) {
			$rfp->payee_firstname = $command->payee_firstname;
			$rfp->payee_middlename = $command->payee_middlename;
			$rfp->payee_lastname = $command->payee_lastname;
			$rfp->date_requested = $command->date_requested;
			$rfp->particulars = $command->particulars;
			$rfp->total_amount = $command->total_amount;
			$rfp->client_id = $command->client_id;
			$rfp->check_num = $command->check_num;
			$rfp->date_needed = $command->date_needed;

			$this->rfpRepository->save($rfp);

			$onlineForm = $this->onlineFormRepository->getFormByFormableID($rfp->id);
			$onlineForm->department_id = $command->department_id;
			$this->onlineFormRepository->save($onlineForm);
		}

		return $rfp;
	}
}