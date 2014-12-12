<?php namespace BCD\OnlineForms\Rejection\Commands;

class AddRejectReasonCommand {
	/**
	* @var mixed
	*/
	public $reason, $form_type, $process_type;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($reason, $form_type, $process_type) {
		$this->reason = $reason;
		$this->form_type = $form_type;
		$this->process_type = $process_type;
	}
}