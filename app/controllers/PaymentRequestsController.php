<?php
use BCD\Core\CommandBus;
use BCD\OnlineForms\OnlineFormRepository;
use BCD\RequestForPayments\RequestForPaymentRepository;
use BCD\Departments\DepartmentRepository;
use BCD\Clients\ClientRepository;
use BCD\Employees\EmployeeRepository;
use BCD\OnlineForms\RFP\Validation\CreateRequestForPaymentForm;
use BCD\OnlineForms\RFP\CreateRFPCommand;
use BCD\OnlineForms\RFP\EditRFPCommand;

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
	* @var RequestForPaymentRepository $requestForPayments
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

		$this->beforeFilter('auth');
		$this->beforeFilter('csrf', ['on' => 'post']);
	}

	/**
	 * Display a listing of the resource.
	 * GET /paymentrequests
	 *
	 * @return Response
	 */
	public function index()
	{
		$forms = $this->requestForPayments->getUserForms(Auth::user());
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
		$formNum = $this->onlineForms->generateFormNum('BCD\RequestForPayments\RequestForPayment');
		$departments = $this->departments->listDepartmentByName();
		$clients = $this->clients->listClientsByName();

		return View::make('account.forms.rfp.create', ['pageTitle' => 'Request for Payment'], compact('formNum', 'departments', 'clients'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /paymentrequests
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('form_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'requestor', 'department_id', 'date_needed');

		$this->createRequestForPaymentForm->validate($input);

		extract($input);

		$makeRequest = $this->execute(
			new CreateRFPCommand($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $requestor, $department_id, $date_needed)
		);

		if($makeRequest) {
			Flash::success('You have successfully made a payment request! <a href="' . URL::route('rfps.index') . '"> View list of payment request transactions.</a>');
		}
		else {
			Flash::error('Failed to make a payment request');
		}
		
		return Redirect::route('rfps.create');
	}

	/**
	 * Display the specified resource.
	 * GET /paymentrequests/{num}
	 *
	 * @param  String  $num
	 * @return Response
	 */
	public function show($num)
	{

		$form = $this->requestForPayments->getFormByFormNum($num);
		return View::make('account.forms.rfp.display', ['pageTitle' => 'Request for Payment', 'subHeading' => 'Transaction Summary'], compact('form'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /paymentrequests/{num}/edit
	 *
	 * @param  String  $num
	 * @return Response
	 */
	public function edit($num)
	{
		$form = $this->requestForPayments->getFormByFormNum($num);
		$departments = $this->departments->orderByName();
		$clients = $this->clients->orderByName();
		return View::make('account.forms.rfp.edit', ['pageTitle' => 'Edit Request for Payment'], compact('form', 'departments', 'clients'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /paymentrequests/{num}
	 *
	 * @param  String  $num
	 * @return Response
	 */
	public function update($num)
	{
		$input = Input::only('form_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'requestor', 'department_id', 'date_needed');

		$this->createRequestForPaymentForm->validate($input);

		extract($input);

		$editRequest = $this->execute(
			new EditRFPCommand($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $requestor, $department_id, $date_needed)
		);

		if($editRequest) {
			Flash::success('You have successfully edited the payment request! <a href="' . URL::route('rfps.show', $form_num) . '"> View payment request.</a>');
		}
		else {
			Flash::error('Failed to make a payment request');
		}
		
		return Redirect::route('rfps.edit', $num);
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

	/**
	* Return pdf version of the form
	*
	* @param String $formNum
	* @return PDF
	*/
	public function pdf($formNum) {
		$rfp = $this->requestForPayments->getFormByFormNum($formNum);
		$view = View::make('account.forms.rfp.pdf', ['pageTitle' => 'Request for Payment'], compact('rfp'));
		return PDF::load($view, 'A4')->show();
	}

}