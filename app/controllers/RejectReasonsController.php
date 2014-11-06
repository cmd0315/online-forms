<?php

use BCD\Core\CommandBus;
use BCD\OnlineForms\Rejection\Validation\RejectReasonForm;
use BCD\OnlineForms\Rejection\AddRejectReasonCommand;
use BCD\OnlineForms\Rejection\EditRejectReasonCommand;
use BCD\OnlineForms\Rejection\RejectReasonRepository;

class RejectReasonsController extends \BaseController {

	use CommandBus;

	/**
	* List of forms
	*
	* @var String $forms
	*/
	protected $forms;

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
		$rejectReasons = $this->rejectReasonRepo->getAll();
		return View::make('admin.display.list-formrejectreasons', ['pageTitle' => 'Reject Reasons'], compact('rejectReasons'));
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
		return View::make('admin.create.formrejectreason', ['pageTitle' => 'Add Reject Reasons to Form'], compact('forms'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /rejectreason
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('forms', 'reason');
		$this->rejectReasonForm->validate($input);
		extract($input);

		$addRejectReason = $this->execute(
			new AddRejectReasonCommand($forms, $reason)
		);

		if($addRejectReason) {
			Flash::success('Reason for rejection is successfully added to the form');
		}
		else {
			Flash::error('Failed to add reject reason');
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
		$associatedForms = $this->rejectReasonRepo->getAssociatedForms($id);

		return View::make('admin.edit.formrejectreason', ['pageTitle' => 'Reject Reason'], compact('rejectReason', 'forms', 'associatedForms'));
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
		$input = Input::only('forms', 'reason');
		$this->rejectReasonForm->validate($input);
		extract($input);

		$addRejectReason = $this->execute(
			new EditRejectReasonCommand($id, $forms, $reason)
		);

		if($addRejectReason) {
			Flash::success('Reason for rejection is successfully edited');
		}
		else {
			Flash::error('Failed to edit reject reason');
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

}