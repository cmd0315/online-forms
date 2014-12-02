<?php namespace BCD\Clients\Registration;

use Laracasts\Commander\CommandHandler;
use BCD\Clients\ClientRepository;
use BCD\Clients\Client;

class AddClientCommandHandler implements CommandHandler {

	/**
	* @var ClientRepository $clientRepository
	*/
	protected $clientRepository;

	/**
	* Constructor
	*
	* @param ClientRepository $clientRepository
	*/
	function __construct(ClientRepository $clientRepository) {
		$this->clientRepository = $clientRepository;
	}

	/**
	* Handle the command
	*
	* @param AddClientCommand $command
	* @return Client
	*/
	public function handle($command) {
		$client = Client::register(
			$command->client_id, $command->client_name, $command->address, $command->cp_first_name, $command->cp_middle_name, $command->cp_last_name, $command->email, $command->mobile, $command->telephone
		);

		$this->clientRepository->save($client);

		return $client;
	}
}