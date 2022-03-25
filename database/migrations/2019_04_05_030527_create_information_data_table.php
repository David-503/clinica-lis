<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInformationDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('information_data', function(Blueprint $table)
		{
			$table->integer('id_information_data', true);
			$table->boolean('highrisk_pregnancy');
			$table->string('location', 100);
			$table->string('ethnic', 100);
			$table->boolean('literate');
			$table->string('studies', 100);
			$table->boolean('lonely')->nullable();
			$table->boolean('tbc')->nullable();
			$table->boolean('diabetes')->nullable();
			$table->boolean('hipertension')->nullable();
			$table->boolean('preeclamsia')->nullable();
			$table->boolean('eclampsia')->nullable();
			$table->string('other_illness', 200)->nullable();
			$table->boolean('surgery')->nullable();
			$table->boolean('infertility')->nullable();
			$table->boolean('heart_disease')->nullable();
			$table->boolean('nephropathy')->nullable();
			$table->boolean('violence')->nullable();
			$table->boolean('VIH')->nullable();
			$table->date('end_of_last_pregnancy')->nullable();
			$table->boolean('planned_pregnancy')->nullable();
			$table->string('contraceptives', 200)->nullable();
			$table->float('last_weight', 53, 0)->nullable();
			$table->float('size', 53, 0)->nullable();
			$table->boolean('antirubeola')->nullable();
			$table->boolean('antitetanica')->nullable();
			$table->boolean('actively_smoke')->nullable();
			$table->boolean('passively_smoke')->nullable();
			$table->boolean('use_drugs')->nullable();
			$table->boolean('alcoholic')->nullable();
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
		Schema::drop('information_data');
	}

}
