<?php namespace BCD\Clients;

use BCD\Clients\Client;

class ClientRepository {
	
	/**
	* Persists a Client
	*
	* @param Client $client
	*/
	public function save(Client $client) {
		return $client->save();
	}

	/**
	* Get all clients that are not deactivated
	*
	* @return Client
	*/
	public function getActiveClients() {
		return Client::where('status', '=', 0);
	}

	/**
	* Return instance of client with given id
	*
	* @param String $id
	* @return Client
	*/
	public function getClientById($id) {
		return Client::where('id', $id)->firstOrFail();
	}

	/**
	* Return instance of client with user-inputted id
	*
	* @param String $id
	* @return Client
	*/
	public function getClientByAssignedId($id) {
		return Client::where('client_id', $id)->firstOrFail();
	}

	/**
	* Return paginated results with search and filter values
	* @param String
	* @param array
	* @return QueryBuilder
	*/
	public function paginateResults($search, array $filterOptions) {
		return $this->getActiveClients()->search($search)->sort($filterOptions)->paginate(5);
	}
	
	/**
	* Return total number of active departments
	*
	* @return int
	*/
	public function total() {
		return $this->getActiveClients()->count();
	}
}