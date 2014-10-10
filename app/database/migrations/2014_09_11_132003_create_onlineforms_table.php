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
			$table->string('form_num', 10)->unique();
			$table->integer('category_id')->unsigned()->index();
			$table->foreign('category_id')->references('id')->on('form_categories')->onDelete('restrict')->onUpdate('cascade');
			$table->string('created_by', 20);
			$table->string('updated_by', 20);
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
