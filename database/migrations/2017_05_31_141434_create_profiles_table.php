<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->decimal('price');
            $table->string('description')->nullable();;
            $table->timestamps();
        });

        Schema::create('exam_profile', function (Blueprint $table) {
            $table->integer('exam_id');
            $table->integer('profile_id');
            $table->foreign('exam_id')->references('id')->on('exams')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('profiles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['exam_id', 'profile_id']);
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
        Schema::dropIfExists('exam_profile');
        Schema::dropIfExists('profiles');
    }
}
