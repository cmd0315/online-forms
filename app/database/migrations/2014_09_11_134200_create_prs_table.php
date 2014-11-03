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
			$table->string('form_num', 10);
			$table->string('control_num', 30)->unique()->nullable();
			$table->string('payee_firstname', 60);
			$table->string('payee_middlename', 60);
			$table->string('payee_lastname', 60);
			$table->date('date_requested');
			$table->text('particulars');
			$table->double('total_amount', 15, 8);
			$table->string('client_id');
			$table->foreign('client_id')->references('client_id')->on('clients')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('check_num');
			$table->date('date_needed')->nullable();
			$table->timestamps();
			$table->softDeletes();
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
