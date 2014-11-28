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
	* @param EditRejectReasonCommand $command
	*/
	public function handle($command) {
		
		$rejectReason = $this->rejectReasonRepo->getReasonByID($command->id);
		$rejectReason->reason = $command->reason;

		$saveEdit = $this->rejectReasonRepo->save($rejectReason);

		if($saveEdit) {
			$associatedForms = $this->rejectReasonRepo->getAssociatedForms($command->id);
			$associatedProcesses = $this->rejectReasonRepo->getAssociatedProcesses($command->id);



			foreach($associatedForms as $associatedForm) {
				if(!(in_array($associatedForm, $command->forms))) {
					foreach($associatedProcesses as $associatedProcess) {
						if(!(in_array($associatedProcess, key($command->process_types)))) {
							$removeRejectReason = $this->formRejectReasonRepo->remove($associatedForm, $command->id, $associatedProcess);
						}
					}
				}
			}

			foreach($command->forms as $form) {
				foreach($command->process_types as $process_type) {
					if(!(in_array($form, $associatedForms) && !(in_array($process_type, $associatedProcesses)))) {
						$formRejectReason = FormRejectReason::add($form, $command->id, $process_type);

						$addRejectReasonToForm = $this->formRejectReasonRepo->save($formRejectReason);
					}
				}
			}

			// foreach($associatedProcesses as $associatedProcess) {
			// 	if(!(in_array($associatedProcess, $command->process_types))) {

			// 		$removeRejectReason = $this->formRejectReasonRepo->removeByProcess($associatedProcess, $command->id);
			// 	}
			// }
		}

		return $saveEdit;
	}
}