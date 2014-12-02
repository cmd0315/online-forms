<?php namespace BCD\RequestForPayments;

use BCD\OnlineForms\OnlineForm;
use BCD\RequestForPayments\RequestForPayment;

class RequestForPaymentRepository {
	
	/**
	* Persists an RequestForPayment
	*
	* @param RequestForPayment $rfp
	*/
	public function save(RequestForPayment $rfp) {
		return $rfp->save();
	}

	/**
	* Return all instance of the form including the trashed
	*
	* @return RequestForPayment
	*/
	public function getAll() {
		return RequestForPayment::withTrashed();
	}
 
	/**
	* Return all forms made by a user
	*
	* @param Account $currentUser
	* @param int $maxRowPerPage
	* @param String $search
	* @param array $filterOptions
	* @return RequestForPayment
	*/
	public function getUserForms($currentUser, $maxRowPerPage, $search, array $filterOptions) {
		//return OnlineForm::currentUserForms($currentUser->username)->formsByCategory('BCD\RequestForPayments\RequestForPayment')->paginate(5);

		return $this->getAll()->userForms($currentUser)->search($search)->sort($filterOptions)->paginate($maxRowPerPage);
	}

	/**
	* Return form by given form number
	*
	* @param String $formNum
	* @return RequestForPayment
	*/
	public function getFormByFormNum($formNum) {
		return $this->getAll()->where('form_num', $formNum)->firstOrFail();
	}

	/**
	* Return form by given form id
	*
	* @param int $id
	* @return RequestForPayment
	*/
	public function getFormByID($id) {
		return $this->getAll()->where('id', $id)->firstOrFail();
	}

	/**
	* Soft delete a payment request by row id
	*
	* @param int $id
	* @return RequestForPayment
	*/
	public function closeForm($id) {
		return $this->getFormByID($id)->delete();
	}

	/**
	* Return formatted results of table rows, to be used for exporting to excel
	*
	* @return array
	*/
	public function getCSVReport() {
		$rfps = $this->getAll()->get();

		$csvArray = [];
		$count = 0;

		foreach($rfps as $rfp) {
			$rfpArr = [
				'#' => ++$count,
				'Form Num' => $rfp->form_num,
				'Status' => $rfp->onlineForm->request_status,
				'Created By' => $rfp->onlineForm->creator->full_name,
				'Created At' => $rfp->onlineForm['created_at']->toDateTimeString(),
				'Last Updated By' => $rfp->onlineForm->updator->full_name,
				'Last Updated At' => $rfp->onlineForm['updated_at']->toDateTimeString(),
				'Date Requested' => $rfp->date_requested,
				'Date Needed' => $rfp->date_needed,
				'Payee' => $rfp->payee_full_name,
				'Total Amount' => $rfp->total_amount,
				'Particulars' => $rfp->particulars,
				'Client' => $rfp->client->client_name,
				'Department' => $rfp->onlineForm->department->department_name,
				'Approved By' => $rfp->onlineForm->approved_by_name,
				'Received By' => $rfp->onlineForm->received_by_name

			];

			if($rfp->isDeleted()) {
				$rfpArr['Deleted At'] = $rfp->onlineForm['deleted_at']->toDateTimeString();
			}

			array_push($csvArray, $rfpArr);
		}

		return $csvArray;
	}
	
}