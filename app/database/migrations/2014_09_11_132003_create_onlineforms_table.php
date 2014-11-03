<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOnlineformsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('onlineforms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->morphs('formable');
			$table->string('created_by', 20);
			$table->foreign('created_by')->references('username')->on('accounts')->onDelete('restrict')->onUpdate('cascade');
			$table->string('updated_by', 20);
			$table->foreign('updated_by')->references('username')->on('accounts')->onDelete('restrict')->onUpdate('cascade');
			$table->string('department_id');
			$table->foreign('department_id')->references('department_id')->on('departments')->onDelete('restrict')->onUpdate('cascade');
			$table->string('approved_by')->nullable();
			$table->foreign('approved_by')->references('username')->on('employees')->onDelete('restrict')->onUpdate('cascade');
			$table->string('received_by')->nullable();
			$table->foreign('received_by')->references('username')->on('employees')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('stage')->default(0);
			$table->integer('status')->default(0);
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
		Schema::drop('onlineforms');
	}

}
