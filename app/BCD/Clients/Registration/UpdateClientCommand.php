<?php namespace BCD\Clients\Registration;

class UpdateClientCommand {

	/**
	* @var String
	*/
	public $id, $client_id, $client_name, $address, $cp_first_name, $cp_middle_name, $cp_last_name, $email, $mobile, $telephone;

	/**
	* Constructor
	*
	* @param String $client_id
	* @param String $client_name
	* @param String $address
	* @param String $cp_first_name
	* @param String $cp_middle_name
	* @param String $cp_last_name
	* @param String $email
	* @param String $mobile
	* @param String $telephone
	*/
	function __construct($id, $client_id, $client_name, $address, $cp_first_name, $cp_middle_name, $cp_last_name, $email, $mobile, $telephone) {
		$this->id = $id;
		$this->client_id = $client_id;
		$this->client_name = $client_name;
		$this->address = $address;
		$this->cp_first_name = $cp_first_name;
		$this->cp_middle_name = $cp_middle_name;
		$this->cp_last_name = $cp_last_name;
		$this->email = $email;
		$this->mobile = $mobile;
		$this->telephone = $telephone;
	}
}