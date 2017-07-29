<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('tipo', 50);
            $table->string('marca');
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->string('unidades')->nullable();
            $table->string('observacion')->nullable();
            $table->string('foto')->nullable();
            $table->integer('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activos');
    }
}
