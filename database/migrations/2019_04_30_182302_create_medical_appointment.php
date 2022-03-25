<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_appointment', function (Blueprint $table) {
            $table->bigIncrements('id_medical_appointment');
            $table->string('code_medical_appointment',8);
            $table->string('id_patient',10);
            $table->string('id_doctor',10);
            $table->boolean('status');
            $table->date('appointment_date');
            $table->time('initial_date');
            $table->time('finalization_date');
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
        Schema::dropIfExists('medical_appointment');
    }
}
