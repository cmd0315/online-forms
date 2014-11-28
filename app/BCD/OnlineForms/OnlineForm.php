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
    * List of all recognized BCD forms
    *
    * @var array
    */
    protected $recognizedForms = ['RequestForPayment'];

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
        return $this->belongsTo('BCD\Employees\Employee', 'created_by', 'username')->withTrashed();
    }

    /**
    * One-to-one relationship between OnlineForm and Employee for updated_by
    */
    public function updator() {
        return $this->belongsTo('BCD\Employees\Employee', 'updated_by', 'username')->withTrashed();
    }

    /**
    * One-to-one relationship between OnlineForm and Employee for approved_by
    */
    public function approver() {
        return $this->belongsToMany('BCD\Employees\Employee', 'username', 'approved_by')->withTrashed();
    }


    /**
    * One-to-one Relationship between RequestForPayment and Department
    */
    public function department() {
        return $this->hasOne('BCD\Departments\Department', 'department_id', 'department_id')->withTrashed();
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
    * Get the full name of the user who approves the form -> for CSV
    *
    * @return String
    */
    public function getApprovedByNameAttribute() {
        if($this->approved_by != null) {
            $employee = Employee::whereUsername($this->approved_by)->firstOrFail();
            return $employee->full_name;
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
    * Get the full name of the user who receives the form -> for CSV
    *
    * @return String
    */
    public function getReceivedByNameAttribute() {
        if($this->received_by != null) {
            $employee = Employee::whereUsername($this->received_by)->firstOrFail();
            return $employee->full_name;
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
    * Check if the form has been deleted
    */
    public function closed() {
        if($this->deleted_at) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Check if form is currently rejected by department head
    *
    * @retun boolean
    */
    public function departmentRejected() {
        if($this->stage === 1 && $this->status === 1) {
            return true;
        }
        else {
            return false;
        }
    }

    public function forApproving() {
        if(!($this->receivingStage()) && !($this->closed())) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Check if the form has been approved by the department head
    *
    * @param boolean
    */
    public function departmentApproved() {
        if($this->stage === 1 && $this->status === 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function receivingStage() {
        if($this->stage>=2) {
            return true;
        }
        else {
            return false;
        }
    }

    public function forReceiving() {
        if(($this->departmentApproved() || $this->receivingStage()) && !($this->closed())) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Check if form is currently rejected by department head
    *
    * @retun boolean
    */
    public function receiverRejected() {
        if($this->stage === 2 && $this->status === 1) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    * Check if the form has been approved by the department head
    *
    * @param boolean
    */
    public function receiverApproved() {
        if($this->stage === 2 && $this->status === 0) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
    *
    * Get status of form
    * @return String
    */
    public function getRequestStatusAttribute() {
        if($this->closed()) {
            return 'Closed';
        }
        else {
            if($this->departmentApproved()) {
                return 'Department Approved';
            }
            else if($this->receiverApproved()) {
                return 'Received';
            }
            else if($this->receiverRejected()) {
                return 'Receiving Denied';
            }
            elseif($this->departmentRejected()) {
                return 'Department Rejected';
            }
            else {
                return 'Pending';
            }
        }
    }

    /**
    *
    * Get formatted status of form
    * @return String
    */
    public function getRequestStatusFormattedAttribute() {
        if($this->closed()) {
            print '<span class="label label-danger">Closed</span>';
        }
        else {
            if($this->departmentApproved()) {
                print '<span class="label label-success">Department Approved</span>';
            }
            else if($this->receiverApproved()) {
                print '<span class="label label-success">Received</span>';
            }
            else if($this->receiverRejected()) {
                print '<span class="label label-danger">Receiving Denied</span>';
            }
            elseif($this->departmentRejected()) {
                print '<span class="label label-danger">Department Rejected</span>';
            }
            else {
                print '<span class="label label-default">Pending</span>';
            }
        }
    }

    /**
    * Check if form can still be edited
    *
    * @return boolean
    */
    public function isEditable() {
        if($this->departmentApproved() || $this->receiverApproved()) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
    * Check if form type is included in the list of recognized forms
    *
    * @param String $formType
    * @return boolean
    */
    public function isRecognized($formType) {
        if(in_array($formType, $this->recognizedForms)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function isPending() {
        if(!($this->departmentApproved()) || !($this->departmentRejected()) || !($this->receiverApproved()) || !($this->receiverRejected())) {
            return true;
        }
        else {
            return false;
        }
    }
}
