<?php

use BCD\Core\CommandBus;
use BCD\Forms\AddClientForm;
use BCD\Forms\UpdateClientProfileForm;
use BCD\Clients\ClientRepository;
use BCD\Clients\Registration\AddClientCommand;
use BCD\Clients\Registration\UpdateClientCommand;
use BCD\OnlineForms\ExportToExcel;

class ClientsController extends \BaseController {

	use CommandBus;

	/**
	* @var AddClientForm
	*/
	protected $addClientForm;

	/**
	* @var UpdateClientForm
	*/
	protected $updateClientForm;

	/**
	* @var ClientRepository
	*/
	protected $clients;

	/**
	* Constructor
	*
	* @param AddClientForm $addClientForm
	* @param ClientRepository $clients
	*/
	public function __construct(AddClientForm $addClientForm, UpdateClientProfileForm $updateClientForm, ClientRepository $clients) {
		$this->addClientForm = $addClientForm;
		$this->updateClientForm = $updateClientForm;
		$this->clients = $clients;

		$this->beforeFilter('auth');

		$this->beforeFilter('role:System Administrator', ['except' => 'show']);

		$this->beforeFilter('csrf', ['on' => 'post']);
	}

	
	/**
	 * Display a listing of the resource.
	 * GET /clients
	 *
	 * @return Response
	 */
	public function index()
	{
		$search = Request::get('q');
		$sortBy = Request::get('sortBy');
		$direction = Request::get('direction');

		//$clients = Client::where('status', '=', 0)->paginate(5);
		$clients = $this->clients->paginateResults($search, compact('sortBy', 'direction'));
		$total_clients = $this->clients->total();

		return View::make('admin.display.list-clients', ['pageTitle' => 'Manage Client Records'], compact('clients', 'total_clients', 'search'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /clients/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.create.client', ['pageTitle' => 'Add Client Record']);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /clients
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('client_id', 'client_name', 'address', 'cp_first_name', 'cp_middle_name', 'cp_last_name', 'email', 'mobile', 'telephone');
		$this->addClientForm->validate($input);

		extract($input);

		$registration = $this->execute(new AddClientCommand($client_id, $client_name, $address, $cp_first_name, $cp_middle_name, $cp_last_name, $email, $mobile, $telephone));

		if($registration) {
			Flash::success('Account for' . $client_name . ' client has been successfully created! <a href="' . URL::route('clients.index') . '"> View list of clients.</a>');
		}
		else {
			Flash::error('Failed to create ' . $client_name .  ' client');
		}

		return Redirect::route('clients.create');
	}

	/**
	 * Display the specified resource.
	 * GET /clients/{id}
	 *
	 * @param  String  $id
	 * @return Response
	 */
	public function show($id)
	{
		$client = $this->clients->getClientByAssignedId($id);
		return View::make('admin.display.client-profile', ['pageTitle' => 'Client Profile'], compact('client'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /clients/{id}/edit
	 *
	 * @param  String  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client = $this->clients->getClientByAssignedId($id);
		return View::make('admin.edit.client', ['pageTitle' => 'Edit Client Information'], compact('client'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /clients/{id}
	 *
	 * @param  String  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::only('client_id', 'client_name', 'address', 'cp_first_name', 'cp_middle_name', 'cp_last_name', 'email', 'mobile', 'telephone');
		
		$this->updateClientForm->validate($input);

		extract($input);

		$updateClient = $this->execute(new UpdateClientCommand($id, $client_id, $client_name, $address, $cp_first_name, $cp_middle_name, $cp_last_name, $email, $mobile, $telephone));

		if($updateClient) {
			Flash::success('Client Profile of ' .  $client_name . ' has been successfully updated! <a href="' . URL::route('clients.show', $client_id) . '"> View client profile.</a>');
		}
		else {
			Flash::error('Failed to edit client account of ' . $client_name . '!');
		}

		return Redirect::route('clients.edit', $client_id);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /clients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	* Export list of clients to Excel
	*
	* @return Excel
	*/
	public function export() 
	{
		$clients = $this->clients->getActiveClients()->get();

		$excel = new ExportToExcel($clients, 'List of Clients');

		return $excel->export();
	}

}