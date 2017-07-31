<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->integer('sucursal_id');
            $table->integer('activo_id');
            $table->integer('estado_id');
            $table->string('ubicacion');
            $table->integer('minimo');
            $table->integer('maximo');
            $table->primary(['sucursal_id', 'activo_id']);
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('activo_id')->references('id')->on('activos');
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
        Schema::dropIfExists('inventarios');
    }
}
