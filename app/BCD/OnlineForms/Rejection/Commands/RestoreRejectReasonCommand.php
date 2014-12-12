<?php namespace BCD\OnlineForms\Rejection\Commands;

class RestoreRejectReasonCommand {

	/**
	*
	* @var int
	*/
	public $id;

	/**
	* Constructor
	*
	* @param int
	*/
	function __construct($id) {
		$this->id = $id;
	}
}