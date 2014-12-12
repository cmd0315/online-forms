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
    * Required attribute for soft deletion
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
     * The db table columns that can be filled
     *
     * @var array
     */
    protected $fillable = ['formable_id', 'formable_type', 'created_by', 'updated_by', 'department_id', 'approved_by', 'received_by', 'stage', 'status'];

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
    * Polymorphic relationship with models that have formable key
    */
    public function formable() {
        return $this->morphTo();
    }

    /**
    * Get full name of the user who created the form
    *
    * @return String
    */
    public function getCreatedByFormattedAttribute() {
        if($this->created_by !== NULL)
            return $this->creator->full_name;
        else
            return '---';
    }

    /**
    * Return the full name of the user who created the form with the link to his profile
    *
    * @return String
    */
    public function getCreatedByWithLinkAttribute() {
        if($this->getCreatedByFormattedAttribute() !== '---')
            print '<a href="' . URL::route('employees.show', $this->creator->username) . '">' . $this->getCreatedByFormattedAttribute() . '</a>';
        else
            print $this->getCreatedByFormattedAttribute();
    }

    /**
    * Get full name of the user who last updated the form
    *
    * @return String
    */
    public function getUpdatedByFormattedAttribute() {
        if($this->updated_by !== NULL)
            return $this->updator->full_name;
        else
            return '---';
    }

    /**
    * Return the full name of the user who last updated the form with the link to his profile
    *
    * @return String
    */
    public function getUpdatedByWithLinkAttribute() {
        if($this->getUpdatedByFormattedAttribute() !== '---')
            print '<a href="' . URL::route('employees.show', $this->updator->username) . '">' . $this->getUpdatedByFormattedAttribute() . '</a>';
        else
            print $this->getUpdatedByFormattedAttribute();
    }
   
    /**
    * Get full name of the user who has approved the form
    *
    * @return String
    */
    public function getApprovedByFormattedAttribute() {
        if($this->approved_by !== NULL)
            return $this->approver->full_name;
        else
            return '---';
    }


   /**
    * Return the full name of the user who has received the form with the link to his profile
    *
    * @return String
    */
    public function getApprovedByWithLinkAttribute() {
        if($this->getApprovedByFormattedAttribute() !== '---')
            print '<a href="' . URL::route('employees.show', $this->approver->username) . '">' . $this->getApprovedByFormattedAttribute() . '</a>';
        else
            print $this->getApprovedByFormattedAttribute();
    }

      /**
    * Get full name of the user who has received the form
    *
    * @return String
    */
    public function getReceivedByFormattedAttribute() {
        if($this->received_by !== NULL)
            return $this->receiver->full_name;
        else
            return '---';
    }


   /**
    * Return the full name of the user who has approved the form with the link to his profile
    *
    * @return String
    */
    public function getReceivedByWithLinkAttribute() {
        if($this->getReceivedByFormattedAttribute() !== '---')
            print '<a href="' . URL::route('employees.show', $this->receiver->username) . '">' . $this->getReceivedByFormattedAttribute() . '</a>';
        else
            print $this->getReceivedByFormattedAttribute();
    }

}
