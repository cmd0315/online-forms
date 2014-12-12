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
	* Return all row items include those that have been soft deleted
	*
	* @return RejectReason
	*/
	public function getAll() {

		return RejectReason::withTrashed();
	}

	/**
	* Return reason by provided text
	*
	* @param String $reason
	* @return RejectReason
	*/
	public function findReason($reason) {
		$reason = $this->getAll()->where('reason', 'LIKE', '%' . $reason . '%')->get();

		return $reason;
	}

	/**
	* Check if reason already exists
	*
	* @param String 
	* @return boolean
	*/
	public function reasonExists($reason, $form_type, $process_type) {
		$rejectReason = $this->getAll()->where('reason', $reason)->where('form_type', $form_type)->where('process_type', $process_type)->get();

		if(count($rejectReason) > 0) {
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
	* Get RejectReason by id
	*
	* @param int $id
	* @return RejectReason
	*/
	public function getReasonByID($id) {

		return $this->getAll()->where('id', $id)->firstOrFail();
	}

	/**
	* Return paginated results with search and filter values
	*
	* @param int
	* @param String
	* @param array
	* @return QueryBuilder
	*/
	public function paginateResults($maxRowPerPage, $search, array $filterOptions) {
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

	/**
	* Return total number of active rejectReasons (except system admin)
	*
	* @return int 
	*/
	public function activeTotal() {
		return RejectReason::all()->count();
	}

	/**
	* Soft delete reject reason
	*
	* @param int $id
	*/
	public function remove($id) {

		return $this->getReasonByID($id)->delete();
	}


    /**
    * Restore reject reason
    *
    * @param int $id
    * @return RejectReason
    */
    public function restore($id) {
        $rejectReason = $this->getReasonByID($id);
        return $rejectReason->restore();
    }

    	/**
	* Return formatted results of table rows, to be used for exporting to excel
	*
	* @return array
	*/
	public function getCSVReport() {
		$rejectReasons = $this->getAll()->get();

		$csvArray = [];
		$count = 0;

		foreach($rejectReasons as $rejectReason) {

			$rejectReasonArray = [
				'#' => ++$count,
				'Reason' => $rejectReason->reason,
				'Form Type' => $rejectReason->form_type,
				'Process Type' => $rejectReason->process_type,
				'Created At' => $rejectReason['created_at']->toDateTimeString(),
				'Updated At' => $rejectReason['updated_at']->toDateTimeString()
			];

			if($rejectReason->isDeleted()) {
				$rejectReasonArray['Deleted At'] = $rejectReason['deleted_at']->toDateTimeString();
			}

			array_push($csvArray, $rejectReasonArray);
		}

		return $csvArray;
	}

}