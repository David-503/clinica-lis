<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIdentificationFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('identification_files', function(Blueprint $table)
		{
			$table->integer('id_identification_file', true);
			$table->boolean('gender');
			$table->integer('age')->nullable();
			$table->string('marital_status', 50);
			$table->string('occupation', 50);
			$table->string('father_name', 100)->nullable();
			$table->string('mother_name', 100)->nullable();
			$table->string('couple_name', 100)->nullable();
			$table->string('attendant_name', 100);
			$table->string('attendant_address', 150);
			$table->string('attendant_phone', 9);
			$table->string('provided_information_name', 150);
			$table->string('provided_information_relationship', 75);
			$table->string('provided_information_dui', 10);
			$table->string('couple_provided_information_name', 150)->nullable();
			$table->string('take_information_name', 150);
			$table->date('inscription_date');
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
		Schema::drop('identification_files');
	}

}
