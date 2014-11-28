<?php namespace BCD\OnlineForms;

class ApproveRequestCommand {
	/**
	* @var mixed
	*/
	public $formID, $decisionOptions, $formRejectReasons, $approver;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($formID, $decisionOptions, $formRejectReasons, $approver) {
		$this->formID = $formID;
		$this->decisionOptions = $decisionOptions;
		$this->formRejectReasons = $formRejectReasons;
		$this->approver = $approver;
	}
}