<?php namespace BCD\OnlineForms\Rejection;

class EditRejectReasonCommand {
	/**
	* @var mixed
	*/
	public $id, $forms, $process_types, $reason;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($id, $forms, $process_types, $reason) {
		$this->id = $id;
		$this->forms = $forms;
		$this->process_types = $process_types;
		$this->reason = $reason;
	}
}