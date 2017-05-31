<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sucursal_id')->unsigned();
            $table->integer('sample_id')->unsigned();
            $table->integer('exam_category_id')->unsigned();
            $table->integer('estado_id')->nullable();
            $table->string('name');
            $table->string('display_name');
            $table->decimal('precio', 8, 2);
            $table->decimal('material_directo', 8, 2)->default(0);
            $table->decimal('mano_obra', 8, 2)->default(0);
            $table->decimal('cif', 8, 2)->default(0);
            $table->string('observation');
            $table->timestamps();
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('sample_id')->references('id')->on('samples');
            $table->foreign('exam_category_id')->references('id')->on('exam_categories');
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
        Schema::dropIfExists('exams');
    }
}
