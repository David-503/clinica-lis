<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMedicalMonitoringTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('medical_monitoring', function(Blueprint $table)
		{
			$table->foreign('id_promoter', 'FK__medical_m__id_pr__267ABA7A')->references('dui')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_patient', 'FK__medical_m__id_pa__276EDEB3')->references('id_patient')->on('patients')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('medical_monitoring', function(Blueprint $table)
		{
			$table->dropForeign('FK__medical_m__id_pr__267ABA7A');
			$table->dropForeign('FK__medical_m__id_pa__276EDEB3');
		});
	}

}
