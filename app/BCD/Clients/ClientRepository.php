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
	* Get all clients by name to be listed on select tag
	*
	* @return Department
	*/
	public function listClientsByName() {
		return Client::orderBy('client_name')->lists('client_name', 'client_id');
	}

	/**
	* Get all clients ordered by client name
	*
	* @return Client
	*/
	public function orderByName() {
		return Client::orderBy('client_name')->get();
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