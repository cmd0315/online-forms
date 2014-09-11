<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientPrTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_pr', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('client_id')->unsigned()->index();
			$table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('pr_id')->unsigned()->index();
			$table->foreign('pr_id')->references('id')->on('prs')->onDelete('restrict')->onUpdate('cascade');
			$table->text('particulars');
			$table->double('amount', 15, 8);
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
		Schema::drop('client_pr');
	}

}
