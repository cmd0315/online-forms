<?php namespace BCD\OnlineForms\Rejection;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon;

class RejectReason extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reject_reasons';

	
	/**
	 * The db table columns that can be filled
	 *
	 * @var array
     */
	protected $fillable = ['reason', 'form_type', 'process_type'];

    /**
    * List of datatable column names that can be filtered
    *
    * @var array
    */
    protected $filter_fields = ['reason', 'form_type', 'process_type', 'created_at', 'updated_at'];

    /**
    * Required attribute for soft deletion
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
    * Many-to-many relationship between RejectReason and RejectionHistory
    */
    public function rejectionHistories() {
        return $this->hasMany('BCD\OnlineForms\Rejection\RejectionHistory', 'id', 'reason_id');
    }

    /**
    * Create an instance of the model.
    *
    * @param String
    * @return RejectReason
    */
    public static function add($reason, $form_type, $process_type) {
        $rejectReason = new static(compact('reason', 'form_type', 'process_type'));

        return $rejectReason;
    }

    /**
    * Check if the entry has already been softdeleted
    *
    * @return boolean
    */
    public function isDeleted() {
        if($this->deleted_at !== NULL) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Check if sort can be performed on the datatable
    *
    * @param array $params
    * @return boolean
    */
    public function isSortable(array $params) {
        if(in_array($params['sortBy'], $this->filter_fields)) {
            return $params['sortBy'] and $params['direction'];
        }
    }


    /**
    * Return table rows containing search value
    *
    * @param $query
    * @param String
    * @return $query
    */
    public function scopeSearch($query, $search) {
        if(isset($search)) {
            return $query->where(function($query) use ($search)
            {
                $table_name = $this->table . '.*';
                $query->select($table_name)
                        ->where($this->table . '.reason', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.form_type', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.process_type', 'LIKE', "%$search%");
                
                $query->get();
            });
        }
        else {
            return $query;
        }
    }


    /**
    * Sort datatable by the given database field and sort query direction
    *
    * @param array $params
    * @return RejectReason
    */
    public function scopeSort($query, array $params) {
        if($this->isSortable($params)) {
            $sortBy = $params['sortBy'];
            $direction = $params['direction'];

            return $query->orderBy($sortBy, $direction);
        }
        else {
            return $query;
        }
    }

    /**
    * Return formatted status of the reject reason based on deleted_at value
    *
    * @return String
    */
    public function getStatusAttribute() {
        if($this->isDeleted()) {
            print '<span class="label label-danger">Deleted</span>';
        }
        else {
            print '<span class="label label-success">Active</span>';
        }
    }

}
