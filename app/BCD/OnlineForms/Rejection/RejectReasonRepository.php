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
		return RejectReason::orderBy('created_at', 'DESC')->paginate(15);
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


}