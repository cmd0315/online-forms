<?php namespace BCD\OnlineForms;

class ApproveReceiveRequestCommand {
	/**
	* @var mixed
	*/
	public $formID, $decisionOptions, $formRejectReasons, $receiver;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($formID, $decisionOptions, $formRejectReasons, $receiver) {
		$this->formID = $formID;
		$this->decisionOptions = $decisionOptions;
		$this->formRejectReasons = $formRejectReasons;
		$this->receiver = $receiver;
	}
}