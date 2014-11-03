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

    /**
    * List of datatable column names that can be filtered
    *
    * @var array
    */
    protected $filter_fields = ['department_id', 'department_name', 'created_at', 'updated_at'];


    protected $dates = ['deleted_at'];

    /**
    * One-to-many Relationship between Department and Employee
    */
    public function employees() {
    	return $this->hasMany('BCD\Employees\Employee', 'department_id', 'department_id');
    }

    /**
    * One-to-one Relationship between Department and OnlineForm
    */
    public function onlineForm() {
        return $this->belongsTo('BCD\OnlineForms\OnlineForm', 'department_id', 'department_id');
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
                        ->where($this->table . '.department_id', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.department_name', 'LIKE', "%$search%");
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

            if($sortBy == 'last_name'){
                $table_name = $this->table . '.*';
                $table_primary_key = $this->table . '.department_id';
                return $query
                        ->select($table_name) // Avoid 'ambiguous column name' for paginate() method
                        ->leftJoin('employees', $table_primary_key, '=', 'employees.department_id') // Include related table
                        ->orderBy('employees.' . $sortBy, $direction); // Finally sort by related column
            }
            else {
                return $query->orderBy($sortBy, $direction);
            }
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