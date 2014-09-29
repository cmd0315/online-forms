<?php namespace BCD\Employees;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;

class Employee extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

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
	 * Specify the kind of relationship between the employee and department model from the perspective of the employee model
	 *
	 * @return dependency between the two models
	 */
    public function department() {
        return $this->belongsTo('BCD\Departments\Department', 'department_id', 'department_id')->withTrashed();
    }

    /**
     * Check if user has system admin position
     *
     * @return boolean
     */
    public function getSystemAdminAttribute() {
    	if($this->position == 2) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    public function getHeadAttribute() {
        if($this->position == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getFullNameAttribute() {
    	return ucfirst($this->first_name) . ' ' . ucfirst($this->middle_name) . ' ' . ucfirst($this->last_name);
    }

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

    public function scopeHead($query) {
        return $query->where('position', '1');
    }


    public function scopeSearch($query, $search) {
        return $query->where(function($query) use ($search)
        {
            $query->where('username', 'LIKE', "%$search%")
                    ->orWhere('first_name', 'LIKE', "%$search%")
                    ->orWhere('middle_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%")
                    ->orWhere('address', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('mobile', 'LIKE', "%$search%")
                    ->orWhereHas('department', function($q) use ($search) {
                        $q->where('department_name', 'LIKE', "%$search%");
                    })->get();
        })->where('position', '<', '2'); //exclude system admin
    }

    /**
    * Register an employee
    *
    * @param String $username, String $first_name, String $middle_name, String $last_name, 
    * @param String $birthdate, String $address, String $email, String $mobile, Integer $department_id, Integer $position
    * @return Employee
    *
    */
    public static function register($username, $first_name, $middle_name, $last_name, $birthdate, $address, $email, $mobile, $department_id) {
        $employee = new static(compact('username', 'first_name', 'middle_name', 'last_name', 'birthdate', 'address', 'email', 'mobile', 'department_id'));
 
        return $employee;

        //raise an event
    }
}


