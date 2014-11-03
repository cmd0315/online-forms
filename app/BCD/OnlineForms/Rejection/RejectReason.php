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
	protected $fillable = ['reason'];

    /**
    * Required attribute for soft deletion
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
    * Many-to-many relationship between RejectReason and FormRejectReason
    */
    public function formRejectReasons() {

    	return $this->belongsToMany('BCD\OnlineForms\Rejection\FormRejectReason', 'reject_reason_id', 'id');
    }

    /**
    * Many-to-many relationship between RejectReason and RejectionHistory
    */
    public function rejectionHistories() {
        $this->belongsToMany('BCD\OnlineForms\Rejection\RejectionHistory', 'reason_id', 'id');
    }

}
