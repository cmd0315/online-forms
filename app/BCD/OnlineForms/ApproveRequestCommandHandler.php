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

		if($command->decisionOptions == 0) {
			//add user's username to OnlineForm record, update stage and status

			$rejected = $this->rejectionHistoryRepo->getRowByFormID($command->formID);

			if($rejected) {
				foreach($rejected as $r) {
					$r->delete();
				}
			}

			$onlineForm->stage = 1; //update stage
			$onlineForm->status = 0; //update status
			$onlineForm->approved_by = $command->approver;
			$this->onlineFormRepo->save($onlineForm);

		}
		else {
			//add row to rejection history

			foreach($command->reason_id as $reason_id) {
				$rfp = RejectionHistory::addRow($command->formID, $reason_id);
			
				$this->rejectionHistoryRepo->save($rfp);
			}

			$onlineForm->stage = 0; //update stage
			$onlineForm->status = 1; //update status
			$onlineForm->approved_by = NULL;
			$this->onlineFormRepo->save($onlineForm);
		}
		return $onlineForm;

	}
}