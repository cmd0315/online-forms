<?php namespace BCD\RequestForPayments;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon, URL;

class RequestForPayment extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'prs';


	
	/**
	 * The db table columns that can be filled
	 *
	 * @var array
     */
	protected $fillable = ['form_num', 'control_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'date_needed'];

    protected $dates = ['deleted_at'];

    /**
    * One-to-one relationship between RequestForPayment and OnlineForm
    */
    public function onlineForm() {
    	return $this->morphOne('BCD\OnlineForms\OnlineForm', 'formable');
    }

    /**
    * One-to-one relationship between RequestForPayment and Client
    */
    public function client() {
    	return $this->belongsTo('BCD\Clients\Client', 'client_id', 'client_id');
    }

    /**
    * Create instance of the model.
    *
    * @param mixed
    * @return RequestForPayment
    */
    public static function createRequest($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $date_needed) {

    	$requestForPayment = new static(compact('form_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'date_needed'));

    	return $requestForPayment;
    }

    /**
    * Get the full name of the payee
    *
    * return String
    */
    public function getPayeeFullNameAttribute() {
    	return ucfirst($this->payee_firstname) . ' ' . ucfirst($this->payee_middlename) . ' ' . ucfirst($this->payee_lastname);
    }

    /**
    * Get the total amount in the nearest hundredth
    *
    * @return String
    */
    public function getTotalAmountFormattedAttribute() {
    	return sprintf('%01.2f', $this->total_amount);
    }

    public function getClientFormattedAttribute() {
        print '<a href="' . URL::route('clients.show', $this->client->client_id) . '">' . $this->client->client_name . '</a>';
    }

    /**
    * Filter request for payments
    *
    * @param String
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

}
