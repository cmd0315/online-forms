<?php namespace BCD\Clients\Registration;

use Laracasts\Commander\CommandHandler;
use BCD\Clients\ClientRepository;

class UpdateClientCommandHandler implements CommandHandler {

	/**
	* ClientRepository $clientRepository
	*/
	protected $clientsRepository;

	/**
	* Constructor
	*
	* @param ClientRepository $clientsRepository
	*/
	function __construct(ClientRepository $clientsRepository) {
		$this->clientsRepository = $clientsRepository;
	}

	/**
	* Handles the command
	*
	* @param UpdateClientCommand $command
	* @return Client
	*/
	public function handle($command) {
		$client = $this->clientsRepository->getClientById($command->id);

		$updateClient = '';

		if($client) {
			$client->client_id = $command->client_id;
			$client->client_name = $command->client_name;
			$client->address = $command->address;
			$client->cp_first_name = $command->cp_first_name;
			$client->cp_middle_name = $command->cp_middle_name;
			$client->cp_last_name = $command->cp_last_name;
			$client->email = $command->email;
			$client->mobile = $command->mobile;
			$client->telephone = $command->telephone;

			$updateClient = $this->clientsRepository->save($client);
		}

		return $client;
	}
}