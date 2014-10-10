<?php
use BCD\Core\CommandBus;
use BCD\OnlineForms\OnlineFormRepository;
use BCD\RequestForPayments\RequestForPaymentRepository;
use BCD\Departments\DepartmentRepository;
use BCD\Clients\ClientRepository;
use BCD\Employees\EmployeeRepository;
use BCD\OnlineForms\RFP\Validation\CreateRequestForPaymentForm;
use BCD\OnlineForms\RFP\CreateRFPCommand;

class PaymentRequestsController extends \BaseController {

	use CommandBus;

	/**
	* @var CreateRequestForPaymentForm $createRequestForPaymentForm
	*/
	protected $createRequestForPaymentForm;


	/**
	* @var OnlineFormRepository $onlineForms
	*/
	protected $onlineForms;

	/**
	* @var RequestForPayments $requestForPayments
	*/
	protected $requestForPayments;

	/**
	* @var DepartmentRepository $departments
	*/
	protected $departments;

	/**
	* @var ClientRepository $clients
	*/
	protected $clients;

	/**
	* @var EmployeeRepository $employees
	*/
	protected $employees;

	/**
	* Constructor
	*
	* @param RequestForPaymentForm $requestForPaymentForm
	*/
	public function __construct(CreateRequestForPaymentForm $createRequestForPaymentForm, OnlineFormRepository $onlineForms, RequestForPaymentRepository $requestForPayments, DepartmentRepository $departments, ClientRepository $clients, EmployeeRepository $employees) {

		$this->createRequestForPaymentForm = $createRequestForPaymentForm;
		$this->onlineForms = $onlineForms;
		$this->requestForPayments = $requestForPayments;
		$this->departments = $departments;
		$this->clients = $clients;
		$this->employees = $employees;
	}

	/**
	 * Display a listing of the resource.
	 * GET /paymentrequests
	 *
	 * @return Response
	 */
	public function index()
	{
		$forms = $this->requestForPayments->getUserForms(Auth::user()->username);
		return View::make('account.forms.rfp.index', ['pageTitle' => 'Request For Payment'], compact('forms'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /paymentrequests/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$formNum = $this->onlineForms->generateFormNum('rfp');
		$departments = $this->departments->listDepartmentByName();
		$clients = $this->clients->listClientsByName();
		$approvers = $this->employees->listEmployeesByPosition();

		return View::make('account.forms.rfp.create', ['pageTitle' => 'Request for Payment'], compact('formNum', 'departments', 'clients', 'approvers'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /paymentrequests
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('form_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'requestor', 'department_id', 'date_needed', 'approved_by');

		$this->createRequestForPaymentForm->validate($input);

		extract($input);

		$makeRequest = $this->execute(
			new CreateRFPCommand($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $requestor, $department_id, $date_needed, $approved_by)
		);

		if($makeRequest) {
			Flash::success('You have successfully made a payment request');
		}
		else {
			Flash::error('Failed to make a payment request');
		}
		
		return Redirect::route('rfp.create');
	}

	/**
	 * Display the specified resource.
	 * GET /paymentrequests/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /paymentrequests/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /paymentrequests/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /paymentrequests/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}