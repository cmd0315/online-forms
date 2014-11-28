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
	* Get all clients including softdeleted, to be ordered according to the date deleted
	*
	* @return Client
	*/
	public function getAll() {
		return Client::withTrashed()->orderBy('deleted_at', 'ASC');
	}

	/**
	* Get all clients that are not deactivated
	*
	* @return Client
	*/
	public function getActiveClients() {
		return Client::whereNull('deleted_at');
	}

	/**
	* Return instance of client with given id
	*
	* @param String $id
	* @return Client
	*/
	public function getClientById($id) {
		return Client::withTrashed()->where('id', $id)->firstOrFail();
	}

	/**
	* Return instance of client with user-inputted id
	*
	* @param String $id
	* @return Client
	*/
	public function getClientByAssignedId($id) {
		return Client::withTrashed()->where('client_id', $id)->firstOrFail();
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
	*
	* @param int $maxRowPerPage
	* @param String
	* @param array
	* @return QueryBuilder
	*/
	public function paginateResults($maxRowPerPage, $search, array $filterOptions) {
		return $this->getAll()->search($search)->sort($filterOptions)->paginate($maxRowPerPage);
	}
	
	/**
	* Return total number of active departments
	*
	* @return int
	*/
	public function total() {
		return $this->getAll()->count();
	}

	/**
	* Return total number of active departments
	*
	* @return int
	*/
	public function totalActive() {
		return $this->getActiveClients()->count();
	}

	/**
	* Remove client by given client ID
	*
	* @param String $clientID
	* @return Client
	*/
	public function remove($clientID) {
		$client = $this->getClientByAssignedId($clientID);

		$client->delete();
	}

	/**
	* Restore client by given client ID
	*
	* @param String $clientID
	* @return Client
	*/
	public function restore($clientID) {
		$client = $this->getClientByAssignedId($clientID);

		$client->restore();
	}

	/**
	* Return formatted results of table rows, to be used for exporting to excel
	*
	* @return array
	*/
	public function getCSVReport() {
		$clients = $this->getAll()->get();

		$csvArray = [];
		$count = 0;

		foreach($clients as $client) {
			$clientArr = [
				'#' => ++$count,
				'Client ID' => $client->client_id,
				'Client Name' => $client->client_name,
				'Address' => $client->address,
				"Contact Person's First Name" => $client->cp_first_name,
				"Contact Person's Middle Name" => $client->cp_middle_name,
				"Contact Person's Last Name" => $client->cp_last_name,
				'Email' => $client->email,
				'Mobile' => $client->mobile,
				'Telephone' => $client->telephone,
				'Status' => $client->status,
				'Created At' => $client['created_at']->toDateTimeString(),
				'Updated At' => $client['updated_at']->toDateTimeString()
			];

			if($client->isDeleted()) {
				$clientArr['Deleted At'] = $client['deleted_at']->toDateTimeString();
			}

			array_push($csvArray, $clientArr);
		}

		return $csvArray;
	}
}