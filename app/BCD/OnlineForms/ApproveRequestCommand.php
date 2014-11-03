<?php namespace BCD\OnlineForms;

class ApproveRequestCommand {
	/**
	* @var mixed
	*/
	public $formID, $decisionOptions, $reason_id, $approver;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($formID, $decisionOptions, $reason_id, $approver) {
		$this->formID = $formID;
		$this->decisionOptions = $decisionOptions;
		$this->reason_id = $reason_id;
		$this->approver = $approver;
	}
}