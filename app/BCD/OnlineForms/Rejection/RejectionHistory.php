<?php namespace BCD\OnlineForms\Rejection;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon;

class RejectionHistory extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rejection_history';

	
	/**
	 * The db table columns that can be filled
	 *
	 * @var array
     */
	protected $fillable = ['form_id', 'form_reject_reason_id'];

    /**
    * Required attribute for soft deletion
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
    * Many-to-many relationship between RejectionHistory and RejectReason
    *
    * @return 
    */
    public function rejectReasons() {
        return $this->belongsTo('BCD\OnlineForms\Rejection\RejectReason', 'reject_reason_id', 'id')->withTrashed();
    }

    /**
    * Create an instance of the model.
    *
    * @return RejectionHistory
    */
    public static function addRow($form_id, $form_reject_reason_id) {
    	$rejectionHistory = new static(compact('form_id', 'form_reject_reason_id'));

    	return $rejectionHistory;
    }


}
