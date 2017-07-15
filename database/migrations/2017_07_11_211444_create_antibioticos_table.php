<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntibioticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antibioticos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });

        Schema::create('antibioticos_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });
        Schema::create('register_antibiotico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examen_paciente_id');
            $table->integer('antibiotico_id');
            $table->integer('antibiotico_type_id');

            $table->foreign('examen_paciente_id')->references('id')->on('examen_paciente');
            $table->foreign('antibiotico_id')->references('id')->on('antibioticos');
            $table->foreign('antibiotico_type_id')->references('id')->on('antibioticos_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_antibiotico');
        Schema::dropIfExists('antibioticos_type');
        Schema::dropIfExists('antibioticos');
    }
}
