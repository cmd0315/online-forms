<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRejectionHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rejection_history', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned();
			$table->foreign('form_id')->references('id')->on('onlineforms')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('form_reject_reason_id')->unsigned();
			$table->foreign('form_reject_reason_id')->references('id')->on('form_reject_reasons')->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('rejection_history');
	}

}
