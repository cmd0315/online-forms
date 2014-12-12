<?php namespace BCD\OnlineForms\Rejection\Commands;

use Laracasts\Commander\CommandHandler;
use BCD\OnlineForms\Rejection\RejectReasonRepository;

class RemoveRejectReasonCommandHandler implements CommandHandler {

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
	* @param RemoveRejectReasonCommand $command
	*/
	public function handle($command) {
		$rejectReasonDelete = $this->rejectReasonRepo->remove($command->id);
		
		return $rejectReasonDelete;

	}
}