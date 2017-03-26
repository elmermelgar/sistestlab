<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grouping_id')->unsigned();
            $table->integer('estado_id')->nullable();
            $table->string('name_detail');
            $table->string('tipo_vr');
            $table->string('unidades');
            $table->string('description');
            $table->timestamps();
            $table->foreign('grouping_id')->references('id')->on('groupings');
            $table->foreign('estado_id')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_details');
    }
}
