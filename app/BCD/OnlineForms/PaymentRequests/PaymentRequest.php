<?php namespace BCD\OnlineForms\PaymentRequests;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon, URL;

class PaymentRequest extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var String
	 */
	protected $table = 'prs';

    /**
    * Required for softdeletion
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
	 * The db table columns that can be filled
	 *
	 * @var array
     */
	protected $fillable = ['form_num', 'control_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'date_needed'];

	/**
    * One-to-one relationship between RequestForPayment and Client
    */
    public function client() {
    	return $this->belongsTo('BCD\Clients\Client', 'client_id', 'client_id')->withTrashed();;
    }

    /**
    * One-to-one relationship between RequestForPayment and OnlineForm
    */
    public function onlineForm() {
    	return $this->morphOne('BCD\OnlineForms\OnlineForm', 'formable')->withTrashed();
    }

    /**
    * Create instance of the model.
    *
    * @param mixed
    * @return PaymentRequest
    */
    public static function createRequest($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $date_needed) {

        $paymentRequest = new static(compact('form_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'date_needed'));

        return $paymentRequest;
    }

    /**
    * Get payee's full name by concating his first, middle and last names 
    *
    * @return String 
    */
    public function getPayeeFullNameAttribute() {
        $full_name = ucfirst($this->payee_firstname);

        if($this->payee_middlename) {
            $full_name .= ' ' . ucfirst($this->payee_middlename);
        }

        $full_name .= ' ' . ucfirst($this->payee_lastname);

        return $full_name;
    }

    
    /**
    * Filter request for payments
    *
    * @param $query
    * @param Account $currentUser
    * @return query
    */
    public function scopeUserForms($query, $currentUser) {
        $table_name = $this->table . '.*';
        $table_primary_key = $this->table . '.id';

        $query = $query->select($table_name)
                       ->leftJoin('onlineforms', $table_primary_key, '=', 'onlineforms.formable_id'); // Include related table

        if($currentUser->employee->finance_department) {
            return $query;
        }
        else if($currentUser->employee->head) {
           $query = $query->where('onlineforms.department_id', $currentUser->employee->department_id);
        }
        else {
            $query = $query->where('onlineforms.created_by', $currentUser->username);
        }

        return $query;
    }


    /**
    * Get the total amount in the nearest hundredth
    *
    * @return String
    */
    public function getTotalAmountFormattedAttribute() {
        return sprintf('%01.2f', $this->total_amount);
    }

}
