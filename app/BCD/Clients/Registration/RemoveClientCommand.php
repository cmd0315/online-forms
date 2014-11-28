<?php namespace BCD\Clients\Registration;

class RemoveClientCommand {

	/**
	* String $client_id
	*/
	public $client_id;


	/**
	* Constructor
	*
	* @param String $client_id
	*/
	function __construct($client_id) {
		$this->client_id = $client_id;
	}
}