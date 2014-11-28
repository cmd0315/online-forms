<?php namespace BCD\OnlineForms;

use Laracasts\Commander\CommandHandler;
use BCD\OnlineForms\OnlineFormsRepository;
use BCD\OnlineForms\Rejection\RejectionHistory;
use BCD\OnlineForms\Rejection\RejectionHistoryRepository;

class ApproveRequestCommandHandler implements CommandHandler {

	/**
	* @var OnlineFormRepository $onlineFormRepository
	*/
	protected $onlineFormRepo;

	/**
	* @var RejectionHistoryRepository $rejectionHistoryRepo
	*/
	protected $rejectionHistoryRepo;


	public function __construct(OnlineFormRepository $onlineFormRepository, RejectionHistoryRepository $rejectionHistoryRepository) {

		$this->onlineFormRepo = $onlineFormRepository;
		$this->rejectionHistoryRepo = $rejectionHistoryRepository;
	}

	/**
	* Handles the command.
	*
	* @param ApproveRequest $command
	*/
	public function handle($command) {

		$onlineForm = $this->onlineFormRepo->getFormByID($command->formID);
		$onlineForm->stage = 1; //update stage

		if($command->decisionOptions == 0) {
			//add user's username to OnlineForm record, update stage and status

			$rejected = $this->rejectionHistoryRepo->getRowByFormID($command->formID);

			if($rejected) {
				foreach($rejected as $r) {
					$r->delete();
				}
			}

			$onlineForm->status = 0; //update status
			$onlineForm->approved_by = $command->approver;
		}
		else {
			//add row to rejection history
			foreach($command->formRejectReasons as $form_reject_reason_id) {
				if(!($this->rejectionHistoryRepo->rowHistoryExists($command->formID, $form_reject_reason_id))) {
					$rfp = RejectionHistory::addRow($command->formID, $form_reject_reason_id);
					$this->rejectionHistoryRepo->save($rfp);
				}
			}

			$onlineForm->status = 1; //update status
			$onlineForm->approved_by = NULL;
		}

		$this->onlineFormRepo->save($onlineForm);

		return $onlineForm;
	}
}