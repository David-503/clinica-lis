<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPhonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('phones', function(Blueprint $table)
		{
			$table->foreign('id_usuario', 'FK__phones__id_usuar__15502E78')->references('dui')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('phones', function(Blueprint $table)
		{
			$table->dropForeign('FK__phones__id_usuar__15502E78');
		});
	}

}
