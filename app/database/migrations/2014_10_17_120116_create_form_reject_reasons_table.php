<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormRejectReasonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('form_reject_reasons', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('formable_type', 250);
			$table->integer('reject_reason_id')->unsigned();
			$table->foreign('reject_reason_id')->references('id')->on('reject_reasons')->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('form_reject_reasons');
	}

}
