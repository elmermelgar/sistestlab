<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_registro', function (Blueprint $table) {
            $table->integer('sucursal_id');
            $table->date('fecha');
            $table->integer('estado');
            $table->time('hora');
            $table->decimal('efectivo', 8, 2)->default(0);
            $table->decimal('debito', 8, 2)->default(0);
            $table->decimal('credito', 8, 2)->default(0);
            $table->primary(['sucursal_id', 'fecha', 'estado']);
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caja_registro');
    }
}
