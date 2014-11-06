<?php namespace BCD\OnlineForms\Rejection;

class EditRejectReasonCommand {
	/**
	* @var mixed
	*/
	public $id, $forms, $reason;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($id, $forms, $reason) {
		$this->id = $id;
		$this->forms = $forms;
		$this->reason = $reason;
	}
}