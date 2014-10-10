<?php namespace BCD\Clients;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon;

class Client extends Eloquent {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clients';

	/**
	 * The fields that are allowed to be filled.
	 *
	 * @var array
	 */
	protected $fillable = array('client_id', 'client_name', 'address', 'cp_first_name', 'cp_middle_name', 'cp_last_name', 'email', 'mobile', 'telephone', 'status');

	protected $dates = ['deleted_at'];

	/**
    * List of datatable column names that can be filtered
    *
    * @var array
    */
    protected $filter_fields = ['client_id', 'client_name', 'address', 'cp_last_name', 'email', 'mobile', 'telephone', 'created_at', 'updated_at'];

    /**
    * One-to-one relationship between RequestForPayment and Client
    */
    public function paymentRequests() {
        return $this->hasOne('BCD\RequestForPayments\RequestForPayment', 'client_id', 'client_id');
    }

	/**
    * Create instance of Client
    *
    * @param String $client_id
    * @param String $client_name
    */
    public static function register($client_id, $client_name, $address, $cp_first_name, $cp_middle_name, $cp_last_name, $email, $mobile, $telephone) {
    	$client = new static(compact('client_id', 'client_name', 'address', 'cp_first_name', 'cp_middle_name', 'cp_last_name', 'email', 'mobile', 'telephone'));

    	return $client;
    }

     /**
    * Convert the format of the date the department was last updated into a readable form
    * 
    * @return Carbon
    */
    public function getLastProfileUpdateAttribute() {
        $year = date('Y', strtotime($this->updated_at));
        $month = date('m', strtotime($this->updated_at));
        $day = date('j', strtotime($this->updated_at));
        $hr = date('g', strtotime($this->updated_at));
        $min = date('i', strtotime($this->updated_at));
        $sec = date('s', strtotime($this->updated_at));
        
        return Carbon::create($year, $month, $day, $hr, $min, $sec)->diffForHumans();
    }

    public function getContactPersonAttribute() {
        return ucfirst($this->cp_first_name) . ' ' . ucfirst($this->cp_middle_name) . ' ' . ucfirst($this->cp_last_name);
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
                        ->where($this->table . '.client_id', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.client_name', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.address', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.cp_first_name', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.cp_middle_name', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.cp_last_name', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.email', 'LIKE', "%$search%");
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
    * @return Client
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
}