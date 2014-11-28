<?php

use BCD\Core\CommandBus;
use BCD\OnlineForms\Rejection\Validation\RejectReasonForm;
use BCD\OnlineForms\Rejection\AddRejectReasonCommand;
use BCD\OnlineForms\Rejection\EditRejectReasonCommand;
use BCD\OnlineForms\Rejection\RejectReasonRepository;
use BCD\OnlineForms\ExportToExcel;

class RejectReasonsController extends \BaseController {

	use CommandBus;

	/**
	* List of forms
	*
	* @var String $forms
	*/
	protected $forms;

    /**
    * The list of all form processes
    *
    * @var array
    */
    protected $processes;

	/**
	* @var RejectReasonForm $rejectReasonForm
	*/
	protected $rejectReasonForm;

	/**
	* @var RejectReasonRepository $rejectReasonRepo
	*/
	protected $rejectReasonRepo;


	/**
	* Constructor
	*
	* @param RejectReasonsForm
	*/
	public function __construct(RejectReasonForm $rejectReasonForm, RejectReasonRepository $rejectReasonRepository) {
		$this->rejectReasonForm = $rejectReasonForm;

		$this->rejectReasonRepo = $rejectReasonRepository;

		$this->forms = ['BCD\RequestForPayments\RequestForPayment' => 'Request For Payment', 'BCD\CheckVouchers\CheckVoucher' => 'Check Voucher', 'BCD\CashVouchers\CashVoucher' => 'Cash Voucher'];

		$this->processes = ['0' => 'Department Approval', '1' => 'Receiving'];

		$this->beforeFilter('auth');

		$this->beforeFilter('role:System Administrator', ['except' => 'show']);

		$this->beforeFilter('csrf', ['on' => 'post']);
	}
	/**
	 * Display a listing of the resource.
	 * GET /rejectreason
	 *
	 * @return Response
	 */
	public function index()
	{
		$search = Request::get('q');
		$sortBy = Request::get('sortBy');
		$direction = Request::get('direction');

		$total_rejectreasons = $this->rejectReasonRepo->total();

		$rejectReasons = $this->rejectReasonRepo->paginateResults($search, compact('sortBy', 'direction'));
		return View::make('admin.display.list-formrejectreasons', ['pageTitle' => 'Reject Reasons'], compact('rejectReasons', 'total_rejectreasons', 'search'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /rejectreason/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$forms = $this->forms;
		$processes = $this->processes;
		return View::make('admin.create.formrejectreason', ['pageTitle' => 'Add Reject Reasons to Form'], compact('forms', 'processes'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /rejectreason
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('forms', 'process_type', 'reason');
		$this->rejectReasonForm->validate($input);
		extract($input);

		$addRejectReason = $this->execute(
			new AddRejectReasonCommand($forms, $process_type, $reason)
		);

		$referenceUrl = '<a href="' . URL::route('rejectreasons.index') . '">View list here.</a>';
		$msg = '';

		if($addRejectReason) {
			$msg = 'Reason for rejection is successfully added to the form! ' . $referenceUrl;
			Flash::success($msg);
		}
		else {
			$msg = 'Failed to add reject reason! ' . $referenceUrl;
			Flash::error($msg);
		}
		
		return Redirect::route('rejectreasons.create');
	}

	/**
	 * Display the specified resource.
	 * GET /rejectreason/{id}
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
	 * GET /rejectreason/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rejectReason = $this->rejectReasonRepo->getReasonByID($id);
		$forms = $this->forms;
		$processes = $this->processes;
		$associatedForms = $this->rejectReasonRepo->getAssociatedForms($id);
		$associatedProcesses = $this->rejectReasonRepo->getAssociatedProcesses($id);

		return View::make('admin.edit.formrejectreason', ['pageTitle' => 'Reject Reason'], compact('rejectReason', 'forms', 'processes', 'associatedForms', 'associatedProcesses'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /rejectreason/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::only('forms', 'process_types', 'reason');
		$this->rejectReasonForm->validate($input);
		extract($input);

		$addRejectReason = $this->execute(
			new EditRejectReasonCommand($id, $forms, $process_types, $reason)
		);


		$referenceUrl = '<a href="' . URL::route('rejectreasons.index') . '">View list here.</a>';
		$msg = '';

		if($addRejectReason) {
			$msg = 'Reason for rejection is successfully edited! ' . $referenceUrl;
			Flash::success($msg);
		}
		else {
			$msg = 'Failed to edit reject reason! ' . $referenceUrl;
			Flash::error($msg);
		}
		
		return Redirect::route('rejectreasons.edit', $id);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /rejectreason/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	/**
	* Export list of employees to Excel
	*
	* @return Excel
	*/
	public function export() 
	{
		$rejectReasons = $this->rejectReasonRepo->getAll()->get();

		$excel = new ExportToExcel($rejectReasons, 'List of Reject Reasons');

		return $excel->export();
	}

}