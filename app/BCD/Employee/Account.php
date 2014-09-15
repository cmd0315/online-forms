<?php namespace BCD\Employee;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Account extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'accounts';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * The db table columns that can be filled
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'password', 'status'];

    protected $dates = ['deleted_at'];


    /**
	 * Specify the kind of relationship between the account and employee model from the perspective of the account model
	 *
	 * @return dependency between the two models
	 */
	public function employee()
    {
        return $this->hasOne('BCD\Employee\Employee', 'username', 'username');
    }



}


