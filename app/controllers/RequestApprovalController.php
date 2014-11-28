<?php

use BCD\Core\CommandBus;
use BCD\OnlineForms\OnlineFormRepository;
use BCD\OnlineForms\ApproveRequestCommand;
use BCD\OnlineForms\Validation\ApprovalForm;

class RequestApprovalController extends \BaseController {

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
	* @param ApprovalForm $approvalForm
	*/
	public function __construct(OnlineFormRepository $onlineFormRepository, ApprovalForm $approvalForm) {
		$this->onlineFormRepo = $onlineFormRepository;
		$this->approvalForm = $approvalForm;

		$this->beforeFilter('auth');

		$this->beforeFilter('forApproving');

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
	 * @return View
	 */
	public function edit($id)
	{
		$onlineForm = $this->onlineFormRepo->getFormByID($id);
		$formRejectReasons = $this->onlineFormRepo->getFormDepartmentRejectReasons($id);
		$whyRejectedArr = $this->onlineFormRepo->getWhyRejected($id);

		return View::make('account.forms.processes.approval.decision', ['pageTitle' => 'Approve Request'], compact('onlineForm', 'formRejectReasons', 'whyRejectedArr'));
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
		try {
			$this->approvalForm->validate(Input::all());
		}
		catch(FormValidationException $error) {
			return Redirect::back()->withInput()->withErrors($error->getErrors());
		}
		

		$decisionOptions = Input::get('decisionOptions');
		$formRejectReasons = Input::get('formRejectReasons');
		$approver = Input::get('approver');

		$approval = $this->execute(
			new ApproveRequestCommand($id, $decisionOptions, $formRejectReasons, $approver)
		);

		if($approval) {
			$formNum = $this->onlineFormRepo->getFormNum($id);

			$viewRequest = '<a href="' . URL::route('rfps.show', $formNum) . '">View Request here.' . '</a>';
			$msg = '';

			if($decisionOptions == 0) {
				$msg = 'Request approved! ' . $viewRequest;
				Flash::success($msg);
			}
			else {
				$msg = 'Request rejected! ' . $viewRequest;
				Flash::success($msg);
			}
		}
		else{
			Flash::error('Failed to make a decision');
		}
		
		return Redirect::route('approval.edit', $id);
	}

}