<?php namespace BCD\OnlineForms\Rejection;

use Laracasts\Commander\CommandHandler;
use BCD\OnlineForms\Rejection\RejectReasonRepository;
use BCD\OnlineForms\Rejection\FormRejectReasonRepository;

class EditRejectReasonCommandHandler implements CommandHandler {

	/**
	* @var RejectReasonRepository $rejectReasonRepo
	*/
	protected $rejectReasonRepo;

	/**
	* @var FormRejectReasonRepository $formRejectReasonRepo
	*/
	protected $formRejectReasonRepo;


	/**
	* Constructor
	*
	* @param RejectReasonRepository $rejectReasonRepo
	* @param FormRejectReasonRepository $formRejectReasonRepo
	*/
	public function __construct(RejectReasonRepository $rejectReasonRepo, FormRejectReasonRepository $formRejectReasonRepo) {

		$this->rejectReasonRepo = $rejectReasonRepo;
		$this->formRejectReasonRepo = $formRejectReasonRepo;
	}

	/**
	* Handles the command.
	*
	* @param AddRejectReasonCommand $command
	*/
	public function handle($command) {
		
		$rejectReason = $this->rejectReasonRepo->getReasonByID($command->id);
		$rejectReason->reason = $command->reason;

		$saveEdit = $this->rejectReasonRepo->save($rejectReason);

		if($saveEdit) {
			$associatedForms = $this->rejectReasonRepo->getAssociatedForms($command->id);

			foreach($command->forms as $form) {
				if(!(in_array($form, $associatedForms))) {
					$formRejectReason = FormRejectReason::add($form, $command->id);

					$addRejectReasonToForm = $this->formRejectReasonRepo->save($formRejectReason);
				}
			}

			foreach($associatedForms as $associatedForm) {
				if(!(in_array($associatedForm, $command->forms))) {

					$removeRejectReason = $this->formRejectReasonRepo->remove($associatedForm, $command->id);
				}
			}
		}

		return $saveEdit;
	}
}