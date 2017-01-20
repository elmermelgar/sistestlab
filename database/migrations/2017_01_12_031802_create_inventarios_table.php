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
            $table->increments('id');
            $table->string('cod_inventario');
            $table->integer('existencia')->nullable();
            $table->integer('cantidad_minima')->nullable();
            $table->integer('cantidad_maxima')->nullable();
            $table->date('fecha_cargado')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->integer('activo_id')->nullable();
            $table->foreign('activo_id')->references('id')->on('activos');
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
        Schema::dropIfExists('inventarios');
    }
}
