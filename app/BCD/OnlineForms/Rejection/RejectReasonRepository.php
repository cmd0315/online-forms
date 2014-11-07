<?php namespace BCD\OnlineForms\Rejection;

use BCD\OnlineForms\Rejection\RejectReason;

class RejectReasonRepository {

	/**
	* Persists the RejectReason class
	*
	* @param RejectReason $rejectReason
	*/
	public function save(RejectReason $rejectReason) {
		return $rejectReason->save();
	}

	/**
	* Return reason by provided text
	*
	* @param String $reason
	* @return RejectReason
	*/
	public function findReason($reason) {
		$reason = RejectReason::where('reason', 'LIKE', '%' . $reason . '%')->get();

		return $reason;
	}

	/**
	* Check if reason already exists
	*
	* @param String $reason
	* @return boolean
	*/
	public function reasonExists($reason) {
		if(count($this->findReason($reason)) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	* Get the id by using the reason text
	*
	* @param String $reason
	* @return int
	*/
	public function getReasonID($reason) {
		$rejectReason = $this->findReason($reason);

		$id = '';

		if($rejectReason) {
			$id = $rejectReason[0]->id;
		}

		return $id;
	}

	/**
	* Return all reject reasons
	*/
	public function getAll() {
		return RejectReason::where('reason', '!=', '');
	}

	/**
	* Get RejectReason by id
	*
	* @param int $id
	* @return RejectReason
	*/
	public function getReasonByID($id) {

		return RejectReason::where('id', $id)->firstOrFail();
	}


	public function getAssociatedForms($id) {
		$associatedFormsArr = [];

		$rejectReason = $this->getReasonByID($id);

		foreach($rejectReason->formRejectReasons as $formRejectReason) {
			array_push($associatedFormsArr, $formRejectReason->formable_type);
		}

		return $associatedFormsArr;
	}

	/**
	* Return paginated results with search and filter values
	* @param String
	* @param array
	* @return QueryBuilder
	*/
	public function paginateResults($search, array $filterOptions) {
		return $this->getAll()->search($search)->sort($filterOptions)->paginate(5);
	}


	/**
	* Return total number of reject reasons
	*
	* @return int 
	*/
	public function total() {
		return $this->getAll()->count();
	}


}