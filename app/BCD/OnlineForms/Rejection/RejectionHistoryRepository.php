<?php namespace BCD\OnlineForms\Rejection;

use BCD\OnlineForms\Rejection\RejectionHistory;

class RejectionHistoryRepository {

	/**
	* Persists the RejectionHistory class
	*
	* @param RejectionHistory $rejectHistory
	*/
	public function save(RejectionHistory $rejectHistory) {
		return $rejectHistory->save();
	}

	/**
	* Return rejection history rows based on given id
	*
	* @param int $id 
	* @return RejectionHistory
	*/
	public function getRowByFormID($id) {
		return RejectionHistory::where('form_id', $id)->get();
	}

}