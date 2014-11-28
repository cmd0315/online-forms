<?php namespace BCD\Employees;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent;

use BCD\OnlineForms\OnlineForm;

class Employee extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employees';

	/**
	 * The db table columns that can be filled
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'first_name', 'middle_name', 'last_name', 'birthdate', 'address', 'email', 'mobile', 'department_id', 'position'];

    /**
    * List of datatable column names that can be filtered
    * @var array
    */
    protected $filter_fields = ['username', 'last_name', 'birthdate', 'address', 'department_id', 'email', 'position', 'created_at', 'updated_at'];

    /**
    * Required for softdeletion of records
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

	/**
	 * Specifies the model/s that are affected with the changes (db update/delete) made in this model
	 *
	 * @var array
	 */
	protected $touches = ['account'];

	/**
	 * Specify the kind of relationship between the account and employee model from the perspective of the employee model
	 *
	 * @return dependency between the two models
	 */
	public function account()
    {
        return $this->belongsTo('BCD\Employees\Account', 'username', 'username')->withTrashed(); //include soft deleted accounts
    }

    /**
	 * Specify the kind of relationship between the employee and department models from the perspective of the employee model
	 *
	 * @return dependency between the two models
	 */
    public function department() {
        return $this->belongsTo('BCD\Departments\Department', 'department_id', 'department_id')->withTrashed();
    }

    public function createdOnlineForm() {
        return $this->hasMany('BCD\OnlineForms\OnlineForm', 'created_by', 'username');
    }

     public function approvedOnlineForms() {
        return $this->hasMany('BCD\OnlineForms\OnlineForm', 'approved_by', 'username');
    }


    /**
    * Check if employee position is head (= 1)
    *
    * @return boolean
    */
    public function getHeadAttribute() {
        if($this->position == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Check if user is the department head given the department id
    *
    * @param String
    * @return boolean
    */
    public function isDepartmentHead($department_id) {
        if($this->head && $this->department_id == $department_id) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Check if employee is the right approver of the form
    *
    * @param int $formID
    * @return boolean
    */
    public function isForApproving($formID) {
        $online_form = OnlineForm::withTrashed()->where('id', $formID)->firstOrFail();

        if($this->isDepartmentHead($online_form->department_id) && $online_form->forApproving()) {
            return true;
        }
        else{
            return false;
        }
    }

    /**
    * Check if employee can edit the form
    *
    * @return boolean
    */
    public function isForEditing($formID) {
        $online_form = OnlineForm::withTrashed()->where('id', $formID)->firstOrFail();

        if(($this->username === $online_form->created_by) && $online_form->isEditable()) {
            return true;
        }
        else {
            return false;
        }

    }

    /**
    * Check if employee's department is finance (= 1)
    *
    * @return boolean
    */
    public function getFinanceDepartmentAttribute() {
        $department_name = $this->department->department_name;
        if($department_name == 'Finance'){
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Check against a form request using the user information if it's for receiving for the logged in user
    *
    * @param int $id
    * @return boolean
    */
    public function isForReceiving($formID) {
        $online_form = OnlineForm::withTrashed()->where('id', $formID)->firstOrFail();

        if($this->getFinanceDepartmentAttribute() && $online_form->forReceiving()) {
            return true;
        }
        else {
            return false;
        }
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
    * Get employee's full name by concating his first, middle and last names 
    *
    * @return String 
    */
    public function getFullNameAttribute() {
    	return ucfirst($this->first_name) . ' ' . ucfirst($this->middle_name) . ' ' . ucfirst($this->last_name);
    }

    /**
    * Return concatenated first and last names of employee
    *
    * @return String 
    */
    public function getFirstLastNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
    * Translate employee's position into words 
    *
    * @return String 
    */
    public function getPositionTitleAttribute() {
        $position = $this->position;

        if($position == 2) {
            return 'System Administrator';
        }
        else if($position == 1) {
            return 'Head Employee';
        }
        else {
            return 'Member Employee';
        }
    }

   /**
    * Return formatted status of the employee based on deleted_at value
    *
    * @return String
    */
    public function getEmployeeStatusAttribute() {
        if($this->isDeleted()) {
            print '<span class="label label-danger">Inactive</span>';
        }
        else {
            print '<span class="label label-success">Active</span>';
        }
    }

    /**
    * Check if the user has the specified position
    *
    * @param int $id
    * @return boolean
    */
     public function hasPosition($id) {
        if($this->position == $id) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Get employees with position as head employee
    *
    * @param $query
    * @return $query
    */
    public function scopeHead($query) {
        return $query->where('position', '1');
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
    * @return Employee
    */
    public function scopeSearch($query, $search) {
        if(isset($search)) {
            return $query->where(function($query) use ($search)
            {
                $table_name = $this->table . '.*';


                $query->select($table_name)
                        ->where($this->table . '.username', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.first_name', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.middle_name', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.last_name', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.address', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.email', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.mobile', 'LIKE', "%$search%")
                        ->orWhereHas('department', function($q) use ($search) {
                            $q->where('department_name', 'LIKE', "%$search%");
                        });

                if(strcasecmp($search, 'head') == 0) {
                    $query->orWhere($this->table . '.position', '1');
                }
                else if(strcasecmp($search, 'member') == 0) {
                    $query->orWhere($this->table . '.position', '0');
                }
                else if(strcasecmp($search, 'inactive') == 0) {
                    $query->orWhereNotNull($this->table . '.deleted_at');
                }
                else if(strcasecmp($search, 'active') == 0) {
                    $query->orWhereNull($this->table . '.deleted_at');
                }

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
    * @return Employee
    */
    public function scopeSort($query, array $params) {
        if($this->isSortable($params)) {
            $sortBy = $params['sortBy'];
            $direction = $params['direction'];

            if($sortBy == 'created_at' || $sortBy == 'updated_at'){
                
                $table_name = $this->table . '.*';
                $table_primary_key = $this->table . '.username';
                return $query
                        ->select($table_name)
                        ->leftJoin('accounts', $table_primary_key, '=', 'accounts.username')
                        ->orderBy('accounts.' . $sortBy, $direction);
            }

            return $query->orderBy($sortBy, $direction);
        }
        else {
            return $query;
        }
    }

    /**
    * Register an employee
    *
    * @param String
    * @return Employee
    */
    public static function register($username, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department_id) {
        $employee = new static(compact('username', 'first_name', 'middle_name', 'last_name', 'birthdate', 'address', 'email', 'mobile', 'department_id'));
 
        return $employee;

        //raise an event
    }
}


