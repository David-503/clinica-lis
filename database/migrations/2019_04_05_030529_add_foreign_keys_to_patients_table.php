<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPatientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('patients', function(Blueprint $table)
		{
			$table->foreign('id_patient', 'FK__patients__id_pat__1FCDBCEB')->references('dui')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_file', 'FK__patients__id_fil__20C1E124')->references('id_file')->on('files')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('patients', function(Blueprint $table)
		{
			$table->dropForeign('FK__patients__id_pat__1FCDBCEB');
			$table->dropForeign('FK__patients__id_fil__20C1E124');
		});
	}

}
