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
            $table->integer('type');
            $table->string('description')->nullable();
            $table->boolean('enabled')->default(true);
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
        });

        Schema::create('profile_sucursal', function (Blueprint $table) {
            $table->integer('profile_id');
            $table->integer('sucursal_id');
            $table->decimal('price')->default(0);
            $table->foreign('profile_id')->references('id')->on('profiles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sucursal_id')->references('id')->on('sucursales')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['profile_id', 'sucursal_id']);
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
        Schema::dropIfExists('profile_sucursal');
        Schema::dropIfExists('profiles');
    }
}
