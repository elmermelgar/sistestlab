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
            $table->integer('factura_id');
            $table->integer('exam_id');
            $table->integer('paciente_id')->nullable();
            $table->integer('profesional_id')->nullable();
            $table->integer('estado_id')->nullable();
            $table->string('paciente_nombre')->nullable();
            $table->string('paciente_genero',1)->nullable();
            $table->integer('paciente_edad')->nullable();
            $table->string('numero_boleta',8)->nullable();
            $table->string('medico')->nullable();
            $table->date('fecha_resultado')->nullable();
            $table->date('fecha_validado')->nullable();
            $table->string('observacion')->nullable();
            $table->foreign('factura_id')->references('id')->on('facturas');
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
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
