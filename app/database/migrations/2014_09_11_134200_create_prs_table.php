<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('form_num', 10)->unique();
			$table->string('control_num', 30)->unique()->nullable();
			$table->string('payee_firstname', 60);
			$table->string('payee_middlename', 60);
			$table->string('payee_lastname', 60);
			$table->datetime('date_requested');
			$table->double('total_amount', 15, 8);
			$table->integer('check_num');
			$table->integer('requested_by');
			$table->integer('department_id');
			$table->datetime('date_needed')->nullable();
			$table->integer('received_by')->nullable();
			$table->integer('approved_by')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prs');
	}

}
