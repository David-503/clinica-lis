<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('files', function(Blueprint $table)
		{
			$table->foreign('id_identification_file', 'FK__files__id_identi__1BFD2C07')->references('id_identification_file')->on('identification_files')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_information_file', 'FK__files__id_inform__1CF15040')->references('id_information_data')->on('information_data')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('files', function(Blueprint $table)
		{
			$table->dropForeign('FK__files__id_identi__1BFD2C07');
			$table->dropForeign('FK__files__id_inform__1CF15040');
		});
	}

}
