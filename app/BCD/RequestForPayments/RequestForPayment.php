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
	 * @var String
	 */
	protected $table = 'prs';

    /**
    * Directory location of the class
    *
    * @var String
    */
    protected $formable_type = 'BCD\RequestForPayments\RequestForPayment';
	
	/**
	 * The db table columns that can be filled
	 *
	 * @var array
     */
	protected $fillable = ['form_num', 'control_num', 'payee_firstname', 'payee_middlename', 'payee_lastname', 'date_requested', 'particulars', 'total_amount', 'client_id', 'check_num', 'date_needed'];

    /**
    * Required for softdeletion
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
    * List of datatable column names that can be filtered
    *
    * @var array
    */
    protected $filter_fields = ['status', 'created_by', 'created_at', 'updated_by', 'updated_at', 'date_requested', 'date_needed', 'payee_lastname', 'total_amount', 'client_name', 'department_name', 'approved_by', 'received_by'];

    /**
    * One-to-one relationship between RequestForPayment and OnlineForm
    */
    public function onlineForm() {
    	return $this->morphOne('BCD\OnlineForms\OnlineForm', 'formable')->withTrashed();
    }

    /**
    * One-to-one relationship between RequestForPayment and Client
    */
    public function client() {
    	return $this->belongsTo('BCD\Clients\Client', 'client_id', 'client_id')->withTrashed();;
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
    * @return String
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

    /**
    * Get name of associated client with embedded link to its profile profile page
    *
    * @return String
    */
    public function getClientFormattedAttribute() {
        print '<a href="' . URL::route('clients.show', $this->client->client_id) . '">' . $this->client->client_name . '</a>';
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
    * Check if the entry has already been softdeleted
    *
    * @return boolean
    */
    public function isDeleted() {
        if($this->deleted_at !== NULL) {
            return true;
        }
        return false;
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
    * @param String $search
    * @return $query
    */
    public function scopeSearch($query, $search) {
        if(!(isset($search))) {
            return $query;
        }

        return $query->where(function($query) use ($search)
        {
            $table_name = $this->table . '.*';
            $query->select($table_name)
                    ->where($this->table . '.payee_firstname', 'LIKE', "%$search%")
                    ->orWhere($this->table . '.payee_middlename', 'LIKE', "%$search%")
                    ->orWhere($this->table . '.payee_lastname', 'LIKE', "%$search%")
                    ->orWhere($this->table . '.total_amount', 'LIKE', "%$search%")
                    ->orWhere($this->table . '.particulars', 'LIKE', "%$search%")
                    ->orWhereHas('client', function($q) use ($search) {
                        $q->where('client_name', 'LIKE', "%$search%");
                    })
                    ->orWhereHas('onlineform', function($q) use ($search) {
                        $q->leftJoin('departments as dept', 'onlineforms.department_id', '=', 'dept.department_id')
                          ->where('dept.department_name', 'LIKE', "%$search%");
                    })
                    ->orWhereHas('onlineform', function($q) use ($search) {
                        $q->leftJoin('employees as emp', 'onlineforms.created_by', '=', 'emp.username')
                          ->where(function($q) use ($search){
                              $q->where('emp.first_name', 'LIKE', "%$search%")
                                ->OrWhere('emp.middle_name', 'LIKE', "%$search%")
                                ->OrWhere('emp.last_name', 'LIKE', "%$search%");
                          });
                    })
                    ->orWhereHas('onlineform', function($q) use ($search) {
                        $q->leftJoin('employees as emp', 'onlineforms.updated_by', '=', 'emp.username')
                          ->where(function($q) use ($search){
                              $q->where('emp.first_name', 'LIKE', "%$search%")
                                ->OrWhere('emp.middle_name', 'LIKE', "%$search%")
                                ->OrWhere('emp.last_name', 'LIKE', "%$search%");
                          });
                    })
                    ->orWhereHas('onlineform', function($q) use ($search) {
                        $q->leftJoin('employees as emp', 'onlineforms.approved_by', '=', 'emp.username')
                          ->where(function($q) use ($search){
                              $q->where('emp.first_name', 'LIKE', "%$search%")
                                ->OrWhere('emp.middle_name', 'LIKE', "%$search%")
                                ->OrWhere('emp.last_name', 'LIKE', "%$search%");
                          });
                    })
                    ->orWhereHas('onlineform', function($q) use ($search) {
                        $q->leftJoin('employees as emp', 'onlineforms.received_by', '=', 'emp.username')
                          ->where(function($q) use ($search){
                              $q->where('emp.first_name', 'LIKE', "%$search%")
                                ->OrWhere('emp.middle_name', 'LIKE', "%$search%")
                                ->OrWhere('emp.last_name', 'LIKE', "%$search%");
                          });
                    })
                    ->get();
        });
    }

    /**
    * Sort datatable by the given database field and sort query direction
    *
    * @param $query
    * @param array $params
    * @return RequestForPayment
    */
    public function scopeSort($query, array $params) {
        if( !($this->isSortable($params)) ) {
            return $query;
        }
        
        $sortBy = $params['sortBy'];
        $direction = $params['direction'];

        $local_table_name = $this->table . '.*';
        $local_table_primary_key = $this->table . '.username';

        if($sortBy == 'created_by') {

            return $query
                    ->select($local_table_name)
                    ->leftJoin('onlineforms as of', $this->table . '.id', '=', 'of.formable_id')
                    ->leftJoin('employees as emp', 'of.created_by', '=', 'emp.username')
                    ->where('of.formable_type', '=', $this->formable_type)
                    ->orderBy('emp.last_name', $direction);

        }
        else if($sortBy == 'updated_by') {

            return $query
                    ->select($local_table_name)
                    ->leftJoin('onlineforms as of', $this->table . '.id', '=', 'of.formable_id')
                    ->leftJoin('employees as emp', 'of.updated_by', '=', 'emp.username')
                    ->where('of.formable_type', '=', $this->formable_type)
                    ->orderBy('emp.last_name', $direction);

        }    
        else if($sortBy == 'approved_by') {

            return $query
                    ->select($local_table_name)
                    ->leftJoin('onlineforms as of', $this->table . '.id', '=', 'of.formable_id')
                    ->leftJoin('employees as emp', 'of.approved_by', '=', 'emp.username')
                    ->where('of.formable_type', '=', $this->formable_type)
                    ->orderBy('emp.last_name', $direction);

        }
        else if($sortBy == 'received_by') {

            return $query
                    ->select($local_table_name)
                    ->leftJoin('onlineforms as of', $this->table . '.id', '=', 'of.formable_id')
                    ->leftJoin('employees as emp', 'of.received_by', '=', 'emp.username')
                    ->where('of.formable_type', '=', $this->formable_type)
                    ->orderBy('emp.last_name', $direction);

        }
        else if($sortBy == 'department_name'){
            return $query
                    ->select($local_table_name)
                    ->leftJoin('onlineforms as of', $this->table . '.id', '=', 'of.formable_id')
                    ->leftJoin('departments as dept', 'of.department_id', '=', 'dept.department_id')
                    ->where('of.formable_type', '=', $this->formable_type)
                    ->orderBy('dept.' . $sortBy, $direction);
        }
        else if($sortBy == 'client_name'){
            return $query
                    ->select($local_table_name)
                    ->leftJoin('clients', $this->table . '.client_id', '=', 'clients.client_id') 
                    ->orderBy('clients.' . $sortBy, $direction);
        }
        else {
            return $query->orderBy($sortBy, $direction);
        }
    }

}
