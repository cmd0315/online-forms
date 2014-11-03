<?php

use BCD\Core\CommandBus;
use BCD\OnlineForms\OnlineFormRepository;
use BCD\OnlineForms\ApproveRequestCommand;
use BCD\OnlineForms\Validation\ApprovalForm;

class ApprovalController extends \BaseController {

	use CommandBus;

	/**
	* @var OnlineFormRepository $onlineFormRepo
	*/
	protected $onlineFormRepo;

	/**
	* @var ApprovalForm $approvalForm
	*/
	protected $approvalForm;


	/**
	* Constructor
	*
	* @param OnlineFormRepository $onlineFormRepository
	*/
	public function __construct(OnlineFormRepository $onlineFormRepository, ApprovalForm $approvalForm) {
		$this->onlineFormRepo = $onlineFormRepository;
		$this->approvalForm = $approvalForm;

		$this->beforeFilter('auth');

		$this->beforeFilter('approver');

		$this->beforeFilter('csrf', ['on' => 'post']);
	}
	
	/**
	 * Display a listing of the resource.
	 * GET /approval
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /approval/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//return View::make('account.forms.processes.approval.decision', ['pageTitle' => 'Request Decision']);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /approval/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$onlineForm = $this->onlineFormRepo->getFormByID($id);
		$rejectReasons = $this->onlineFormRepo->getFormRejectReasons($id);
		$whyRejected = $this->onlineFormRepo->getWhyRejected($id);

		return View::make('account.forms.processes.approval.decision', ['pageTitle' => 'Request Decision'], compact('onlineForm', 'rejectReasons', 'whyRejected'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /approval/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->approvalForm->validate(Input::all());

		$decisionOptions = Input::get('decisionOptions');
		$rejectReasons = Input::get('rejectReasons');
		$approver = Input::get('approver');

		$approval = $this->execute(
			new ApproveRequestCommand($id, $decisionOptions, $rejectReasons, $approver)
		);

		if($approval) {
			if($decisionOptions == 0) {
				Flash::success('Request approved!');
			}
			else {
				Flash::success('Request rejected!');
			}
		}
		else{
			Flash::error('Failed to make a decision');
		}
		
		return Redirect::route('approval.edit', $id);
	}

}