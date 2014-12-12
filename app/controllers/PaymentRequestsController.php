<?php
use BCD\Core\CommandBus;
use BCD\ExportToExcel;
use BCD\OnlineForms\PaymentRequests\PaymentRequestRepository;
use BCD\OnlineForms\OnlineFormRepository;
use BCD\Departments\DepartmentRepository;
use BCD\Clients\ClientRepository;

use BCD\OnlineForms\PaymentRequests\Validation\CreatePaymentRequestForm;
use BCD\OnlineForms\PaymentRequests\Commands\CreatePaymentRequestCommand;


class PaymentRequestsController extends \BaseController {

	use CommandBus;

	/**
	* @var PaymentRequestRepository $paymentRequestRepo
	*/
	protected $paymentRequestRepo;

	/**
	* @var OnlineFormRepository $onlineFormRepo
	*/
	protected $onlineFormRepo;

	/**
	* @var DepartmentRepository $departments
	*/
	protected $departmentRepo;

	/**
	* @var ClientRepository $clients
	*/
	protected $clientRepo;

	/**
	* @var CreatePaymentRequestForm $createForm
	*/
	protected $createForm;

	/**
	* Directory name of the model
	*/
	protected $dir;

	/**
	* Maximum number of rows to be display per page
	*
	* @var int $maxRowPerPage
	*/
	protected $maxRowPerPage;


	/**
	* Constructor
	*
	* @param PaymentRequestRepository $paymentRequestRepo
	* @param OnlineFormRepository $onlineFormRepo
	* @param DepartmentRepository $departmentRepo
	* @param ClientRepository $clientRepo
	* @param CreatePaymentRequestForm $createPaymentRequestForm
	*
	*/
	public function __construct(PaymentRequestRepository $paymentRequestRepo, OnlineFormRepository $onlineFormRepo, DepartmentRepository $departmentRepo, ClientRepository $clientRepo, CreatePaymentRequestForm $createPaymentRequestForm) {
		
		$this->paymentRequestRepo = $paymentRequestRepo;
		$this->onlineFormRepo = $onlineFormRepo;
		$this->departmentRepo = $departmentRepo;
		$this->clientRepo = $clientRepo;

		$this->createForm = $createPaymentRequestForm;

		$this->dir = 'BCD\OnlineForms\PaymentRequests\PaymentRequest';
		$this->maxRowPerPage = 5;

		$this->beforeFilter('auth');
		$this->beforeFilter('csrf', ['on' => 'post']);
	}

	/**
	 * Display a listing of the resource.
	 * GET /paymentrequests
	 *
	 * @return View
	 */
	public function index()
	{
		$currentPage = 1;

		if (Request::get('page')) {
			$currentPage = Request::get('page');
		}

		$currentRow =  ($this->maxRowPerPage * ($currentPage - 1)) ;
		$paymentRequests = $this->paymentRequestRepo->getUserForms(Auth::user(), $this->maxRowPerPage);
		return View::make('account.online-forms.payment-request.index', ['pageTitle' => 'Request For Payment'], compact('paymentRequests', 'currentRow'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /paymentrequests/create
	 *
	 * @return View
	 */
	public function create()
	{
		$formNum = $this->onlineFormRepo->generateFormNum($this->dir);
		$departments = $this->departmentRepo->listDepartmentByName();
		$clients = $this->clientRepo->listClientsByName();
		return View::make('account.online-forms.payment-request.create', ['pageTitle' => 'Request For Payment'], compact('formNum', 'departments', 'clients'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /paymentrequests
	 *
	 * @return Redirect
	 */
	public function store()
	{
		$inputs = Input::only('form_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'requestor', 'department_id', 'date_needed');


		try {
			$this->createForm->validate($inputs);
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}

		extract($inputs);

		$makeRequest = $this->execute(
			new CreatePaymentRequestCommand($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $requestor, $department_id, $date_needed)
		);

		if($makeRequest) {
			Flash::success('You have successfully made a payment request! <a href="' . URL::route('prs.index') . '"> View list of payment request transactions.</a>');
		}
		else {
			Flash::error('Failed to make a payment request');
		}

		return Redirect::route('prs.create');
	}

	/**
	 * Display the specified resource.
	 * GET /paymentrequests/{num}
	 *
	 * @param  String  $num
	 * @return View
	 */
	public function show($num)
	{

		$paymentRequest = $this->paymentRequestRepo->getFormByFormNum($num);
		return View::make('account.online-forms.payment-request.display', ['pageTitle' => 'Request for Payment', 'subHeading' => 'Transaction Summary'], compact('paymentRequest'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /paymentrequests/{num}/edit
	 *
	 * @param  String  $num
	 * @return View
	 */
	public function edit($num)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /paymentrequests/{num}
	 *
	 * @param  String  $num
	 * @return Redirect
	 */
	public function update($num)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /paymentrequests/{id}
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function destroy($id)
	{
		//
	}

}