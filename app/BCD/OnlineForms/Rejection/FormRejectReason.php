<?php namespace BCD\OnlineForms\Rejection;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon, URL;

class FormRejectReason extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'form_reject_reasons';

	
	/**
	 * The db table columns that can be filled
	 *
	 * @var array
     */
	protected $fillable = ['formable_type', 'reject_reason_id'];

    /**
    * Required attribute for soft deletion
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
    * Many-to-many relationship between FormRejectReason and RejectReason
    *
    * 
    */
    public function rejectReason() {
    	return $this->belongsTo('BCD\OnlineForms\Rejection\RejectReason', 'reject_reason_id', 'id');
    }

    /**
    * One-to-many relationship betwwen OnlineForm and FormRejectReason
    */
    public function onlineForm() {
        return $this->belongsTo('BCD\OnlineForms\OnlineForm', 'formable_type', 'formable_type');
    }

    /**
    * Create an instance of the model.
    *
    * @param String
    */
    public static function add($formable_type, $reject_reason_id) {
        $formRejectReason = new static(compact('formable_type', 'reject_reason_id'));

        return $formRejectReason;
    }

    
    /**
    * Get the type of form
    *
    * @return String
    */
    public function getFormTypeAttribute() {
        $formable_type = explode("\\", $this->formable_type);

        $formType = $formable_type[2];
        if($formType == 'RequestForPayment') {
            print '<a href="' . URL::route('rfps.create') . '">' . $formType . '</a>';
        }
        else {
            return $formType;
        }
    }

}
