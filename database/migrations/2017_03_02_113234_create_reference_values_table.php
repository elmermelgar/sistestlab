<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenceValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_detail_id')->unsigned();
            $table->string('unidades');
            $table->string('value');
            $table->string('gender')->nullable();
            $table->integer('edad_menor')->nullable();
            $table->integer('edad_mayor')->nullable();
            $table->timestamps();
            $table->foreign('exam_detail_id')->references('id')->on('exam_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reference_values');
    }
}
