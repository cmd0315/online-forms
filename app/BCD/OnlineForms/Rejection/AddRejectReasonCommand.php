<?php namespace BCD\OnlineForms\Rejection;

class AddRejectReasonCommand {
	/**
	* @var mixed
	*/
	public $forms, $reason;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($forms, $reason) {
		$this->forms = $forms;
		$this->reason = $reason;
	}
}