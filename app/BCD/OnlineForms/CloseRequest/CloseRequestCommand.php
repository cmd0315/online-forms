<?php namespace BCD\OnlineForms\CloseRequest;

class CloseRequestCommand {

	/**
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

