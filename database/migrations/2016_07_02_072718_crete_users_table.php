<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('user_id');
			$table->string('user_name');
			$table->string('email');
			$table->string('password',60);
			$table->integer('visitor')->unsigned()->nullable();
			$table->integer('user_role_idFk')->unsigned();
			$table->enum('user_status',array(1,0))->default(1);
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::table('users', function($table) {
            $table->foreign('user_role_idFk')->references('role_id')->on('user_roles')->onDelete('restrict');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
