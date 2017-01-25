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
            $table->string('cod_inventario');
            $table->string('nombre_activo');
            $table->date('fecha_adq');
            $table->decimal('precio',10,2);
            $table->string('num_lote')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('tipo',50);
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->string('unidades')->nullable();
            $table->integer('proveedor_id')->nullable();
            $table->integer('sucursal_id')->nullable();
            $table->integer('estado_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('estado_id')->references('id')->on('estados');
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
        Schema::dropIfExists('activos');
    }
}
