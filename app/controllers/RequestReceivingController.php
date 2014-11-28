<?php

use BCD\Core\CommandBus;
use BCD\OnlineForms\OnlineFormRepository;
use BCD\OnlineForms\ApproveReceiveRequestCommand;
use BCD\OnlineForms\Validation\ApprovalForm;

class RequestReceivingController extends \BaseController {
	
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

		$this->beforeFilter('forReceiving');

		$this->beforeFilter('csrf', ['on' => 'post']);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Display the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$onlineForm = $this->onlineFormRepo->getFormByID($id);
		$formRejectReasons = $this->onlineFormRepo->getFormReceiveRejectReasons($id);
		$whyRejectedArr = $this->onlineFormRepo->getWhyRejected($id);

		return View::make('account.forms.processes.receiving.decision', ['pageTitle' => 'Receive Request'], compact('onlineForm', 'formRejectReasons', 'whyRejectedArr'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->approvalForm->validate(Input::all());

		$decisionOptions = Input::get('decisionOptions');
		$formRejectReasons = Input::get('formRejectReasons');
		$receiver = Input::get('receiver');

		$receiving = $this->execute(
			new ApproveReceiveRequestCommand($id, $decisionOptions, $formRejectReasons, $receiver)
		);

		if($receiving) {
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
		
		return Redirect::route('receiving.edit', $id);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
