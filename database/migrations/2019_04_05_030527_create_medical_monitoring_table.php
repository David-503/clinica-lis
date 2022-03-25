<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMedicalMonitoringTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medical_monitoring', function(Blueprint $table)
		{
			$table->integer('id_monitoring', true);
			$table->date('date');
			$table->string('id_promoter', 10);
			$table->string('id_patient', 10);
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
		Schema::disableForeignKeyConstraints();
		Schema::drop('medical_monitoring');
	}

}
