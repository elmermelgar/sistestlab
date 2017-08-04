<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamActiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_activo', function (Blueprint $table) {
            $table->integer('exam_id');
            $table->integer('activo_id');
            $table->integer('cantidad')->default(1);
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('activo_id')->references('id')->on('activos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_activo');
    }
}
