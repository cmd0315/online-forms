<?php namespace BCD\OnlineForms\Rejection\Commands;

use Laracasts\Commander\CommandHandler;
use BCD\OnlineForms\Rejection\RejectReasonRepository;
use BCD\OnlineForms\Rejection\FormRejectReasonRepository;

class AddRejectReasonCommandHandler implements CommandHandler {

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
	* @param AddRejectReasonCommand $command
	*/
	public function handle($command) {
		$rejectReason = '';

		$rejectReason = RejectReason::add($command->reason, $command->form_type, $command->process_type);

		//$addRejectReason = $this->rejectReasonRepo->save($rejectReason);
		if(!($this->rejectReasonRepo->reasonExists($command->reason, $command->form_type, $command->process_type))) {
			$addRejectReason = $this->rejectReasonRepo->save($rejectReason);

			return $addRejectReason;
		}
	}
}