<?php namespace BCD\OnlineForms\Rejection;

class AddRejectReasonCommand {
	/**
	* @var mixed
	*/
	public $forms, $process_type, $reason;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($forms, $process_type, $reason) {
		$this->forms = $forms;
		$this->process_type = $process_type;
		$this->reason = $reason;
	}
}