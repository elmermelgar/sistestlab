<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenPacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_paciente', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('patient_id')->nullable();
            $table->integer('invoice_profile_id');
            $table->integer('account_id')->nullable();
            $table->integer('estado_id')->nullable();
            $table->string('paciente_nombre')->nullable();
            $table->string('paciente_sexo', 1)->nullable();
            $table->integer('paciente_edad')->nullable();
            $table->string('numero_boleta', 8);
            $table->string('medico')->nullable();
            $table->date('fecha_resultado')->nullable();
            $table->date('fecha_validado')->nullable();
            $table->string('observacion')->nullable();
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('invoice_profile_id')->references('id')->on('invoice_profile')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('estado_id')->references('id')->on('estados');
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
        Schema::dropIfExists('examen_paciente');
    }
}
