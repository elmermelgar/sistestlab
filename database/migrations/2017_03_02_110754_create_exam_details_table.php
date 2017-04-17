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
            $table->integer('reference_type_id')->unsigned();
            $table->string('name_detail');
            $table->string('description');
            $table->string('estado')->nullable();
            $table->timestamps();
            $table->foreign('grouping_id')->references('id')->on('groupings');
            $table->foreign('reference_type_id')->references('id')->on('reference_type');
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
