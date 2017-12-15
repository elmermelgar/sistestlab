<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protozoarios_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });

        Schema::create('spermogram_modality', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });
        Schema::create('results', function (Blueprint $table) {
            $table->integer('exam_detail_id');
            $table->integer('examen_paciente_id');
            $table->string('result');
            $table->boolean('out_range')->default(false);
            $table->string('observation')->nullable();
            $table->integer('protozoarios_type_id')->nullable();
            $table->integer('spermogram_modality_id')->nullable();
            $table->foreign('exam_detail_id')->references('id')->on('exam_details');
            $table->foreign('examen_paciente_id')->references('id')->on('examen_paciente');
            $table->foreign('protozoarios_type_id')->references('id')->on('protozoarios_type');
            $table->foreign('spermogram_modality_id')->references('id')->on('spermogram_modality');
            $table->primary(['exam_detail_id', 'examen_paciente_id', 'protozoarios_type_id', 'spermogram_modality_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
        Schema::dropIfExists('spermogram_modality');
        Schema::dropIfExists('protozoarios_type');
    }
}
