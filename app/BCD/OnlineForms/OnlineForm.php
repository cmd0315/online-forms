<?php namespace BCD\OnlineForms;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Carbon, URL;

use BCD\Employees\Employee;

class OnlineForm extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'onlineforms';

	
	/**
	 * The db table columns that can be filled
	 *
	 * @var array
     */
	protected $fillable = ['formable_id', 'formable_type', 'created_by', 'updated_by', 'department_id', 'approved_by', 'received_by', 'stage', 'status'];

    /**
    * Required attribute for soft deletion
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
    * Polymorphic relationship with models that have formable key
    */
    public function formable() {
        return $this->morphTo();
    }

    /**
    * One-to-one relationship between OnlineForm and Employee for created_by
    */
    public function creator() {
        return $this->belongsTo('BCD\Employees\Employee', 'created_by', 'username');
    }

    /**
    * One-to-one relationship between OnlineForm and Employee for updated_by
    */
    public function updator() {
        return $this->belongsTo('BCD\Employees\Employee', 'updated_by', 'username');
    }

    /**
    * One-to-one relationship between OnlineForm and Employee for approved_by
    */
    public function approver() {
        return $this->belongsToMany('BCD\Employees\Employee', 'username', 'approved_by');
    }


    /**
    * One-to-one Relationship between RequestForPayment and Department
    */
    public function department() {
        return $this->hasOne('BCD\Departments\Department', 'department_id', 'department_id');
    }


    /**
    * Many-to-many relationship between OnlineForm and RejectionHistory
    */
    public function rejectHistories() {
        return $this->hasMany('BCD\OnlineForms\Rejection\RejectionHistory', 'form_id', 'id');
    }

    /**
    * One-to-many relationship between OnlineForm and FormRejectReason
    */
    public function formRejectReasons() {
        return $this->hasMany('BCD\OnlineForms\Rejection\FormRejectReason', 'formable_type', 'formable_type');
    }

    /**
    * Return forms by current user
    *
    * @param $query
    * @param String $currentUser
    */
    public function scopeCurrentUserForms($query, $currentUser) {
    	if(isset($currentUser)) {
            return $query->where(function($query) use ($currentUser)
            {
                $query->where('created_by', $currentUser);
            });
        }
        else {
            return $query;
        }
    }

    /**
    * Return forms by category
    *
    * @param $query
    * @param String $category
    * @return $query
    */
    public function scopeFormsByCategory($query, $category) {

    	if(isset($category)) {
            return $query->where(function($query) use ($category)
            {
                $query->where('formable_type', $category);
            });
        }
        else {
            return $query;
        }
    }

   
    /**
    * Get the first and last name of the user who approves the form; 
    * return "---" if form has not yet been approved
    *
    * @return String
    */
    public function getApprovedByFormattedAttribute() {
        if($this->approved_by != null) {
            $employee = Employee::whereUsername($this->approved_by)->firstOrFail();
            print '<a href="' . URL::route('profile.show', $this->approved_by) . '">' . $employee->first_last_name . '</a>';
        }
        else {
            print '---';
        }
    }

    /**
    * Get the first and last name of the user who receives the form;
    * return '---' if form has not yet been received
    *
    * @return String
    */
    public function getReceivedByFormattedAttribute() {
        if($this->received_by != null) {
            $employee = Employee::whereUsername($this->received_by)->firstOrFail();
            print '<a href="' . URL::route('profile.show', $this->received_by) . '">' . $employee->first_last_name . '</a>';
        }
        else
        {
            print '---';
        }
    }

    /**
    * Get the first and last name of the user who created the form 
    *
    * @return String
    */
    public function getCreatedByFormattedAttribute() {
        print '<a href="' . URL::route('profile.show', $this->creator->username) . '">' . $this->creator->first_last_name . '</a>';
    }

    /**
    * Get the first and last name of the user who last updated the form 
    *
    * @return String
    */
    public function getUpdatedByFormattedAttribute() {
        print '<a href="' . URL::route('profile.show', $this->updator->username) . '">' . $this->updator->first_last_name . '</a>';
    }

    /**
    * Get the department associatedd with the form
    *
    * @return String
    */
    public function getDepartmentFormattedAttribute() {
        print '<a href="' . URL::route('departments.show', $this->department->department_id) . '">' . $this->department->department_name . '</a>';
    }

    /**
    * Get the type of form
    *
    * @return String
    */
    public function getFormTypeAttribute() {
        $formable_type = explode("\\", $this->formable_type);

        return $formable_type[2];
    }

    /**
    *
    * Get formatted status of form
    * @return String
    */
    public function getRequestStatusAttribute() {
        if($this->stage == 1 && $this->status == 0) {
            print '<span class="label label-success">Approved</span>';
        }
        elseif($this->stage == 0 && $this->status == 1) {
            print '<span class="label label-danger">Rejected</span>';
        }
        else {
            print '<span class="label label-default">Pending</span>';
        }
    }

    /**
    * Check if form is currently rejected by department head
    *
    * @retun boolean
    */
    public function departmentRejected() {
        if($this->stage == 0 && $this->status == 1) {
            return true;
        }
        else {
            return false;
        }
    }
}
