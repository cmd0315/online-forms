<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 20)->unique();
			$table->string('first_name', 60);
			$table->string('middle_name', 60);
			$table->string('last_name', 60);
			$table->date('birthdate');
			$table->string('address', 500);
			$table->string('email', 50)->unique();
			$table->string('mobile', 15)->nullable();
			$table->string('department_id', 10);
			$table->integer('position')->default(0); //company position(member, department head, system admin); default is member
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
		Schema::drop('employees');
	}

}
