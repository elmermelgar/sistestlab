<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_detail_id')->unsigned();
            $table->text('special_value');
            $table->string('description');
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
        Schema::dropIfExists('special_results');
    }
}
