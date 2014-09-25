<?php namespace BCD\Departments;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon;

class Department extends Eloquent implements UserInterface, RemindableInterface {
	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'departments';

	/**
	 * The db table columns that can be filled
	 *
	 * @var array
	 */
	protected $fillable = ['department_id', 'department_name', 'status'];

    protected $dates = ['deleted_at'];

    public function employees() {
    	return $this->hasMany('BCD\Employees\Employee', 'department_id', 'department_id');
    }


    /**
    * Convert the format of the date the department was last updated into a readable form
    * 
    * @return Carbon
    */
    public function getLastDepartmentProfileUpdateAttribute() {
        $year = date('Y', strtotime($this->updated_at));
        $month = date('m', strtotime($this->updated_at));
        $day = date('j', strtotime($this->updated_at));
        $hr = date('g', strtotime($this->updated_at));
        $min = date('i', strtotime($this->updated_at));
        $sec = date('s', strtotime($this->updated_at));
        
        return Carbon::create($year, $month, $day, $hr, $min, $sec)->diffForHumans();
    }

    /**
    * Get head employee for department
    * 
    * if exists, @return String full_name of employee
    * else, @return String 'None'
    */
    public function getDepartmentHead() {
        $headEmployee = $this->employees()->where('position', '1')->first();
        if($headEmployee) {
            return $headEmployee->full_name;
        }
        else{
            return 'None';
        }

    }

    /**
    * Create instance of Department
    *
    * @param String $department_id
    * @param String $department_name
    */
    public static function register($department_id, $department_name) {
    	$department = new static(compact('department_id', 'department_name'));

    	return $department;
    }


}