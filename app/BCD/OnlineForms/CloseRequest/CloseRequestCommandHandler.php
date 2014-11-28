<?php namespace BCD\OnlineForms\CloseRequest;

use Laracasts\Commander\CommandHandler;
use BCD\RequestForPayments\RequestForPayment;
use BCD\RequestForPayments\RequestForPaymentRepository;
use BCD\OnlineForms\OnlineFormRepository;

class CloseRequestCommandHandler implements CommandHandler {

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
	* OnlineFormRepository $onlineFormRepository
	* RequestForPaymentRepository $rfpRepository
	*/
	public function __construct(OnlineFormRepository $onlineFormRepository, RequestForPaymentRepository $rfpRepository) {

		$this->onlineFormRepository = $onlineFormRepository;
		$this->rfpRepository = $rfpRepository;
	}

	/**
	* Handles the command.
	*
	* @param CloseRequestCommand $command
	*/
	public function handle($command) {
		$onlineForm = $this->onlineFormRepository->getFormByFormableID($command->id);

		$onlineForm->stage = 0;
		$onlineForm->status = 1;

		$updateOnlineForm = $this->onlineFormRepository->save($onlineForm);

		if(($onlineForm->form_type == 'RequestForPayment') && $updateOnlineForm) {
			$closeForm = $this->rfpRepository->closeForm($onlineForm->formable_id);
		}

		return $this->onlineFormRepository->closeRequest($command->id);
	}
}