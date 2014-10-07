<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('client_id', 10)->unique();
			$table->string('client_name', 250)->unique();
			$table->string('address', 250);
			$table->string('cp_first_name', 50);
			$table->string('cp_middle_name', 50);
			$table->string('cp_last_name', 50);
			$table->string('email', 50)->nullable();
			$table->string('mobile', 15)->nullable();
			$table->string('telephone', 15)->nullable();
			$table->integer('status')->default(0); //if active or not; default is active
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
		Schema::drop('clients');
	}

}
