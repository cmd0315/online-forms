<?php namespace BCD\Employees;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Eloquent, Hash, Carbon;

class Account extends Eloquent implements UserInterface, RemindableInterface {

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

	protected $guarded = array();
	
	/**
	 * The db table columns that can be filled
	 *
	 * @var array
	protected $fillable = ['username', 'password', 'status'];

    protected $dates = ['deleted_at'];


    /**
	 * Specify the kind of relationship between the account and employee model from the perspective of the account model
	 *
	 * @return dependency between the two models
	 */
	public function employee()
    {
        return $this->hasOne('BCD\Employees\Employee', 'username', 'username');
    }

    /**
    * Convert the format of the date the account was last updated into a readable form
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
    * Hash password before storing to the database
    * 
    * @param String $password
    */
    public function setPasswordAttribute($password) {
    	$this->attributes['password'] = Hash::make($password);
    }

    /**
    * Add an employee account
    *
    * @param String $username
    * @param String $password
    * @return Account
    */
    public static function addAccount($username, $password) {
    	$account = new static(compact('username', 'password'));

    	return $account;
    }

}


