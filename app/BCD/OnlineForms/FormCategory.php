<?php namespace BCD\OnlineForms;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent, Carbon;

class FormCategory extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'form_categories';

	
	/**
	 * The db table columns that can be filled
	 *
	 * @var array
     */
	protected $fillable = ['name', 'alias'];

	/**
    * One-to-one relationship between FormCategory and OnlineForm.
    */
    public function onlineForm() {
    	return $this->hasOne('BCD\OnlineForms\OnlineForm');
    }

}
