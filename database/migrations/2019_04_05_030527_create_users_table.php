<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->string('dui', 10)->primary('PK__users__D876F1BE4DE6D56B');
			$table->string('name', 50);
			$table->string('lastname', 50);
			$table->string('email');
			$table->string('address', 150);
			$table->string('password');
			$table->date('birthdate');
			$table->boolean('gender');
			$table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
			$table->integer('id_type_user')->nullable();

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::disableForeignKeyConstraints();
		Schema::drop('users');
	}

}
