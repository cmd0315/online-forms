<?php namespace BCD\OnlineForms\Rejection\Commands;

use Laracasts\Commander\CommandHandler;
use BCD\OnlineForms\Rejection\RejectReasonRepository;

class RestoreRejectReasonCommandHandler implements CommandHandler {

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
	* @param RestoreRejectReasonCommand $command
	*/
	public function handle($command) {
		$rejectReasonRestore = $this->rejectReasonRepo->restore($command->id);
		
		return $rejectReasonRestore;

	}
}