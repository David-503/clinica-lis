<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToMedicalAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_appointment', function (Blueprint $table) {
            $table->foreign('id_patient', 'FK__medical_a__id_pa__267ABA7A')->references('dui')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_doctor', 'FK__medical_a__id_do__276EDEB3')->references('dui')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_appointment', function (Blueprint $table) {
            //
        });
    }
}
