<?php namespace BCD\OnlineForms\Rejection\Commands;

class EditRejectReasonCommand {
	/**
	* @var mixed
	*/
	public $id, $reason, $form_type, $process_type;

	/**
	* Constructor
	*
	* @param mixed
	*/
	function __construct($id, $reason, $form_type, $process_type) {
		$this->id = $id;
		$this->reason = $reason;
		$this->form_type = $form_type;
		$this->process_type = $process_type;
	}
}