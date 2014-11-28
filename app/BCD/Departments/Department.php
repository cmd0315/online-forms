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
    	return $this->hasMany('BCD\Employees\Employee', 'department_id', 'department_id')->withTrashed();
    }

    /**
    * One-to-one Relationship between Department and OnlineForm
    */
    public function onlineForm() {
        return $this->belongsTo('BCD\OnlineForms\OnlineForm', 'department_id', 'department_id')->withTrashed();
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
    public function getDepartmentHeadAttribute() {
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
    * @return Department
    */
    public function scopeSearch($query, $search) {
        if(isset($search)) {
            return $query->where(function($query) use ($search)
            {
                $table_name = $this->table . '.*';
                $query->select($table_name)
                        ->where($this->table . '.department_id', 'LIKE', "%$search%")
                        ->orWhere($this->table . '.department_name', 'LIKE', "%$search%")
                        ->orWhereHas('employees', function($q) use ($search) {
                            $q->where('first_name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('employees', function($q) use ($search) {
                            $q->where('middle_name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('employees', function($q) use ($search) {
                            $q->where('last_name', 'LIKE', "%$search%");
                        });

                if(strcasecmp($search, 'active') == 0) {
                    $query->orWhereNull($this->table . '.deleted_at');
                }
                else if(strcasecmp($search, 'inactive') == 0) {
                    $query->orWhereNotNull($this->table . '.deleted_at');
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
    * @param $query
    * @param array $params
    * @return Department
    */
    public function scopeSort($query, array $params) {
        if($this->isSortable($params)) {
            $sortBy = $params['sortBy'];
            $direction = $params['direction'];

            if($sortBy == 'last_name'){
                $table_name = $this->table . '.*';
                $table_key = $this->table . '.department_id';
                return $query
                        ->select($table_name)
                        ->leftJoin('employees', $table_key, '=', 'employees.department_id')
                        ->where('employees.position', '1')
                        ->orderBy('employees.' . $sortBy, $direction);
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
    * Return formatted status of the department based on deleted_at value
    *
    * @return String
    */
    public function getDepartmentStatusAttribute() {
        if($this->isDeleted()) {
            print '<span class="label label-danger">Inactive</span>';
        }
        else {
            print '<span class="label label-success">Active</span>';
        }
    }


}