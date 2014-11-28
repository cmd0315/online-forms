<?php namespace BCD\OnlineForms\Rejection;

use Laracasts\Commander\CommandHandler;
use BCD\OnlineForms\Rejection\RejectReasonRepository;
use BCD\OnlineForms\Rejection\FormRejectReasonRepository;

class AddRejectReasonCommandHandler implements CommandHandler {

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
		$rejectReason = '';

		// check if reason exists, if true add new row to the corresponding database table
		if(!($this->rejectReasonRepo->reasonExists($command->reason))) {
			$rejectReason = RejectReason::add($command->reason);

			$addRejectReason = $this->rejectReasonRepo->save($rejectReason);

			$id = $this->rejectReasonRepo->getReasonID($command->reason);

			if($addRejectReason && $id) {
				foreach($command->forms as $form) {
					$formRejectReason = FormRejectReason::add($form, $id, $command->process_type);

					$addRejectReasonToForm = $this->formRejectReasonRepo->save($formRejectReason);
				}
			}

		}
		
		return $rejectReason;
	}
}