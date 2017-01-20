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
            $table->string('cod_inventario')->unique();
            $table->string('nombre_activo');
            $table->date('fecha_adq');
            $table->decimal('precio',10,2);
            $table->string('num_lote');
            $table->string('ubicacion');
            $table->string('tipo',50);
            $table->string('marca');
            $table->string('modelo');
            $table->string('serie');
            $table->string('unidades');
            $table->integer('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
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
