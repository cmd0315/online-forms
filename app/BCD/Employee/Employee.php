<?php namespace BCD\Employee;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Employee extends \Eloquent implements UserInterface, RemindableInterface {

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
	protected $fillable = ['username', 'first_name', 'middle_name', 'last_name', 'email', 'mobile', 'department_id', 'position'];

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
        return $this->belongsTo('BCD\Employee\Account', 'username', 'username')->withTrashed(); //include soft deleted accounts
    }

    /**
	 * Specify the kind of relationship between the employee and department model from the perspective of the employee model
	 *
	 * @return dependency between the two models
	 */
    // public function department() {
    //     return $this->belongsTo('Department', 'department_id', 'department_id')->withTrashed();
    // }

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

}


