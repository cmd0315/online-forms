<?php
use BCD\Core\CommandBus;
use BCD\Forms\AddClientForm;
use BCD\Forms\UpdateClientProfileForm;
use BCD\Clients\ClientRepository;
use BCD\Clients\Registration\AddClientCommand;
use BCD\Clients\Registration\UpdateClientCommand;
use BCD\Clients\Registration\RemoveClientCommand;
use BCD\Clients\Registration\RestoreClientCommand;
use BCD\ExportToExcel;

class ClientsController extends \BaseController {

	use CommandBus;

	/**
	* @var AddClientForm $addClientForm
	*/
	protected $addClientForm;

	/**
	* @var UpdateClientForm $updateClientForm
	*/
	protected $updateClientForm;

	/**
	* @var ClientRepository $clients
	*/
	protected $clients;

	/**
	* Maximum number of rows to be display per page
	*
	* @var int $maxRowPerPage
	*/
	protected $maxRowPerPage;

	/**
	* Constructor
	*
	* @param AddClientForm $addClientForm
	* @param UpdateClientProfileForm $updateClientForm
	* @param ClientRepository $clients
	*/
	public function __construct(AddClientForm $addClientForm, UpdateClientProfileForm $updateClientForm, ClientRepository $clients) {
		$this->addClientForm = $addClientForm;
		$this->updateClientForm = $updateClientForm;
		$this->clients = $clients;

		$this->maxRowPerPage = 5;

		$this->beforeFilter('auth');

		$this->beforeFilter('role:System Administrator', ['except' => 'show']);

		$this->beforeFilter('csrf', ['on' => 'post']);
	}

	
	/**
	 * Display a listing of the resource.
	 * GET /clients
	 *
	 * @return View
	 */
	public function index()
	{
		$search = Request::get('q');
		$sortBy = Request::get('sortBy');
		$direction = Request::get('direction');

		$currentPage = 1;

		if (Request::get('page')) {
			$currentPage = Request::get('page');
		}

		$currentRow =  ($this->maxRowPerPage * ($currentPage - 1)) ;

		$clients = $this->clients->paginateResults($this->maxRowPerPage, $search, compact('sortBy', 'direction'));
		$active_clients = $this->clients->totalActive();
		$total_clients = $this->clients->total();

		return View::make('admin.display.list-clients', ['pageTitle' => 'Manage Client Records'], compact('clients', 'active_clients', 'total_clients', 'search', 'currentRow'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /clients/create
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('admin.create.client', ['pageTitle' => 'Add Client Record']);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /clients
	 *
	 * @return Redirect
	 */
	public function store()
	{
		$inputs = Input::only('client_id', 'client_name', 'address', 'cp_first_name', 'cp_middle_name', 'cp_last_name', 'email', 'mobile', 'telephone');

		try {
			$this->addClientForm->validate($inputs);
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}

		extract($inputs);

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
	 * GET /clients/{clientID}
	 *
	 * @param  String  $clientID
	 * @return View
	 */
	public function show($clientID)
	{
		$client = $this->clients->getClientByAssignedId($clientID);
		return View::make('admin.display.client-profile', ['pageTitle' => 'Client Profile'], compact('client'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /clients/{clientID}/edit
	 *
	 * @param  String  $clientID
	 * @return View
	 */
	public function edit($clientID)
	{
		$client = $this->clients->getClientByAssignedId($clientID);
		return View::make('admin.edit.client', ['pageTitle' => 'Edit Client Information'], compact('client'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /clients/{id}
	 *
	 * @param  String  $id
	 * @return Redirect
	 */
	public function update($id)
	{
		$inputs = Input::only('client_id', 'client_name', 'address', 'cp_first_name', 'cp_middle_name', 'cp_last_name', 'email', 'mobile', 'telephone');
		
		try {
			$this->updateClientForm->validate($inputs);
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}

		extract($inputs);

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
	 * DELETE /clients/{clientID}
	 *
	 * @param  String  $clientID
	 * @return Response
	 */
	public function destroy($clientID)
	{
		$client_name = $this->clients->getClientByAssignedId($clientID)->client_name; 

		$removeClient = $this->execute(
			new RemoveClientCommand($clientID)
		);

		if($removeClient) {
			Flash::success('Account of ' . $client_name  . ' client has been successfully removed!');

		}
		else{
			Flash::success('Failed to remove account of ' . $client_name . ' client!');

		}
		
		return 	Redirect::route('clients.index');
	}

	/**
	* Export list of clients to Excel
	*
	* @return Excel
	*/
	public function export() 
	{
		$clients = $this->clients->getCSVReport();

		$excel = new ExportToExcel($clients, 'List of Clients');

		return $excel->export();
	}

	/**
	 * Restore the specified resource from storage.
	 * RESTORE /clients/{clientID}
	 *
	 * @param  String  $clientID
	 * @return Redirect
	 */
	public function restore($clientID) {

		$client_name = $this->clients->getClientByAssignedId($clientID)->client_name; 

		$restoreClient = $this->execute(
			new RestoreClientCommand($clientID)
		);

		if($restoreClient) {
			Flash::success('Account of ' . $client_name  . ' client has been successfully restored!');

		}
		else{
			Flash::success('Failed to restore account of ' . $client_name . ' client!');

		}
		
		return 	Redirect::route('clients.index');

	}

}