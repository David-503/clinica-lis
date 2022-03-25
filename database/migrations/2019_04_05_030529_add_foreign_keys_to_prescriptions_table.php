<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPrescriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prescriptions', function(Blueprint $table)
		{
			$table->foreign('id_patient', 'FK__prescript__id_pa__239E4DCF')->references('dui')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('prescriptions', function(Blueprint $table)
		{
			$table->dropForeign('FK__prescript__id_pa__239E4DCF');
		});
	}

}
