<?php

use BCD\Core\CommandBus;
use BCD\ExportToExcel;
use BCD\OnlineForms\Rejection\RejectReasonRepository;
use BCD\OnlineForms\Rejection\Validation\AddRejectReasonForm;
use BCD\OnlineForms\Rejection\Validation\EditRejectReasonForm;
use BCD\OnlineForms\Rejection\Commands\AddRejectReasonCommand;
use BCD\OnlineForms\Rejection\Commands\EditRejectReasonCommand;
use BCD\OnlineForms\Rejection\Commands\RemoveRejectReasonCommand;
use BCD\OnlineForms\Rejection\Commands\RestoreRejectReasonCommand;

class RejectReasonsController extends \BaseController {

	use CommandBus;

	/**
	* @var AddRejectReasonForm $addRejectReasonForm
	*/
	protected $addRejectReasonForm;

	/**
	* @var EditRejectReasonForm $editRejectReasonForm
	*/
	protected $editRejectReasonForm;

	/**
	* @var RejectReasonRepository $rejectReasonRepo
	*/
	protected $rejectReasonRepo;

	/**
	* List of available online forms in the system
	*
	* @var array $onlineForms
	*/
	protected $onlineForms;

	/**
	* List of all availale processes for an online form i.e. department approval and receiving
	*
	* @var array
	*/
	protected $processes;

	/**
	* Maximum number of rows to be display per page
	*
	* @var int $maxRowPerPage
	*/
	protected $maxRowPerPage;


	/**
	* Constructor
	*
	* @param AddRejectReasonForm $addRejectReasonForm
	* @param EditRejectReasonForm $editRejectReasonForm
	* @param RejectReasonRepository $rejectReasonRepository
	*/
	public function __construct(AddRejectReasonForm $addRejectReasonForm, EditRejectReasonForm $editRejectReasonForm, RejectReasonRepository $rejectReasonRepository) {

		$this->addRejectReasonForm = $addRejectReasonForm;
		$this->editRejectReasonForm = $editRejectReasonForm;

		$this->rejectReasonRepo = $rejectReasonRepository;

		$this->onlineForms = ['Payment Request', 'Check Voucher', 'Cash Voucher'];

		$this->processes = ['Department Approval', 'Receiving'];

		$this->maxRowPerPage = 5;

		$this->beforeFilter('auth');
		$this->beforeFilter('role:System Administrator', ['except' => 'show']);
		$this->beforeFilter('csrf', ['on' => 'post']);
	}

	/**
	 * Display a listing of the resource.
	 * GET /rejectreason
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

		$active_rejectreasons = $this->rejectReasonRepo->activeTotal();
		$total_rejectreasons = $this->rejectReasonRepo->total();

		$rejectReasons = $this->rejectReasonRepo->paginateResults($this->maxRowPerPage, $search, compact('sortBy', 'direction'));

		return View::make('admin.display.list-rejectreasons', ['pageTitle' => 'List of Reject Reasons'], compact('rejectReasons', 'active_rejectreasons', 'total_rejectreasons', 'search', 'currentRow'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /rejectreason/create
	 *
	 * @return View
	 */
	public function create()
	{
		$onlineForms = $this->onlineForms;
		$processes = $this->processes;

		return View::make('admin.create.rejectreason', ['pageTitle' => 'Add Reject Reason'], compact('onlineForms', 'processes'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /rejectreason
	 *
	 * @return Redirect
	 */
	public function store()
	{
		$input = Input::only('reason', 'onlineForm', 'processType');
		$this->addRejectReasonForm->validate($input);

		extract($input);

		$addRejectReason = $this->execute(
			new AddRejectReasonCommand($reason, $onlineForm, $processType)
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
	 * @return View
	 */
	public function edit($id)
	{
		$rejectReason = $this->rejectReasonRepo->getReasonByID($id);
		$onlineForms = $this->onlineForms;
		$processes = $this->processes;
		return View::make('admin.edit.rejectreason', ['pageTitle' => 'Edit Reject Reason'], compact('rejectReason', 'onlineForms', 'processes'));
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
		$input = Input::only('reason', 'onlineForm', 'processType');
		$this->editRejectReasonForm->validate($input);

		extract($input);

		$editRejectReason = $this->execute(
			new EditRejectReasonCommand($id, $reason, $onlineForm, $processType)
		);

		$referenceUrl = '<a href="' . URL::route('rejectreasons.index') . '">View list here.</a>';
		$msg = '';

		if($editRejectReason) {
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
		$removeRejectReason = $this->execute(
			new RemoveRejectReasonCommand($id)
		);

		if($removeRejectReason) {
			Flash::success('Reject reason has been successfully removed!');

		}
		else{
			Flash::success('Failed to remove reject reason');
		}
		
		return Redirect::route('rejectreasons.index');
	}


	/**
	* Export list of employees to Excel
	*
	* @return Excel
	*/
	public function export() 
	{
		$rejectReasons = $this->rejectReasonRepo->getCSVReport();

		$excel = new ExportToExcel($rejectReasons, 'List of Reject Reasons');

		return $excel->export();
	}

	/**
	 * Restore reject reason
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function restore($id) {

		$restoreRejectReason = $this->execute(
			new RestoreRejectReasonCommand($id)
		);

		$msg = '<a href="' . URL::route('rejectreasons.index') . '">View list of reject reasons.</a>';

		if($restoreRejectReason) {
			$msg = 'Reject reason has been successfully restored! ' . $msg;
			Flash::success($msg);

		}
		else{
			$msg = 'Failed to restore employee reject reason ' . $msg;
			Flash::success($msg);
		}
		
		return Redirect::route('rejectreasons.edit', $id);
	}

}