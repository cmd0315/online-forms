<?php namespace BCD\OnlineForms;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use BCD\OnlineForms\FormCategory;
use Eloquent, Carbon;

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
	protected $fillable = ['form_num', 'category_id', 'created_by', 'updated_by', 'stage', 'status'];

    protected $dates = ['deleted_at'];

    /**
    * One-to-one relationship between OnlineForm and FormCategory
    */
    public function formCategory() {
    	return $this->belongsTo('BCD\OnlineForms\FormCategory');
    }

    /**
    * One-to-one relationship between OnlineForm and RequestForPayment
    */
    public function paymentRequest() {
    	return $this->hasOne('BCD\RequestForPayments\RequestForPayment', 'form_num', 'form_num');
    }

    /**
    * Create instance of the model.
    *
    * @param mixed
    * @return OnlineForm
    */
    public static function addForm($form_num, $category, $created_by) {
    	$category_id = FormCategory::where('alias', $category)->pluck('id');

    	$onlineForm = new static(compact('form_num', 'category_id', 'created_by'));

    	return $onlineForm;
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
    	$category_id = FormCategory::where('alias', $category)->pluck('id');

    	if(isset($category_id)) {
            return $query->where(function($query) use ($category_id)
            {
                $query->where('category_id', $category_id);
            });
        }
        else {
            return $query;
        }
    }

}
