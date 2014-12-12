<?php namespace BCD\OnlineForms\Rejection\Commands;

use Laracasts\Commander\CommandHandler;
use BCD\OnlineForms\Rejection\RejectReasonRepository;

class EditRejectReasonCommandHandler implements CommandHandler {

	/**
	* @var RejectReasonRepository $rejectReasonRepo
	*/
	protected $rejectReasonRepo;


	/**
	* Constructor
	*
	* @param RejectReasonRepository $rejectReasonRepo
	*/
	public function __construct(RejectReasonRepository $rejectReasonRepo) {

		$this->rejectReasonRepo = $rejectReasonRepo;
	}

	/**
	* Handles the command.
	*
	* @param EditRejectReasonCommand $command
	*/
	public function handle($command) {
		
		$rejectReason = $this->rejectReasonRepo->getReasonByID($command->id);
		$rejectReason->reason = $command->reason;
		$rejectReason->form_type = $command->form_type;
		$rejectReason->process_type = $command->process_type;

		$saveEdit = $this->rejectReasonRepo->save($rejectReason);

		if($saveEdit) {
			return $saveEdit;
		}

	}
}