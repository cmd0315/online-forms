<?php namespace BCD\RequestForPayments;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon;

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
	protected $fillable = ['form_num', 'control_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'department_id', 'date_needed', 'received_by', 'approved_by'];

    protected $dates = ['deleted_at'];

    /**
    * One-to-one relationship between RequestForPayment and OnlineForm
    */
    public function onlineForm() {
    	return $this->belongsTo('BCD\OnlineForms\OnlineForm', 'form_num', 'form_num');
    }

    /**
    * One-to-one relationship between RequestForPayment and Client
    */
    public function client() {
    	return $this->belongsTo('BCD\Clients\Client', 'client_id', 'client_id');
    }

    /**
    * One-to-one Relationship between RequestForPayment and Department
    */
    public function department() {
        return $this->hasOne('BCD\Departments\Department', 'department_id', 'department_id');
    }

    /**
    * One-to-one Relationship between RequestForPayment and Employee for approved_by field
    */
    public function approver() {
    	return $this->hasOne('BCD\Employees\Employee', 'username', 'approved_by');
    }

    /**
    * Create instance of the model.
    *
    * @param mixed
    * @return RequestForPayment
    */
    public static function createRequest($form_num, $payee_firstname, $payee_middlename, $payee_lastname, $date_requested, $particulars, $total_amount, $client_id, $check_num, $department_id, $date_needed, $approved_by) {

    	$requestForPayment = new static(compact('form_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'department_id', 'date_needed', 'approved_by'));

    	return $requestForPayment;
    }

    public function getPayeeFullNameAttribute() {
    	return ucfirst($this->payee_firstname) . ' ' . ucfirst($this->payee_middlename) . ' ' . ucfirst($this->payee_lastname);
    }

    public function getTotalAmountFormattedAttribute() {
    	return sprintf('%01.2f', $this->total_amount);
    }
}
