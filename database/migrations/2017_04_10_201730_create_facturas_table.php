<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sucursal_id');
            $table->integer('cliente_id');
            $table->integer('user_id');
            $table->integer('recolector_id');
            $table->integer('estado_id')->nullable();
            $table->string('numero',8)->nullable();
            $table->decimal('efectivo')->default(0);
            $table->decimal('debito')->default(0);
            $table->decimal('deuda')->default(0);
            $table->decimal('total')->default(0);
            $table->boolean('credito_fiscal')->default(false);
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('recolector_id')->references('id')->on('recolectores');
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
        Schema::dropIfExists('facturas');
    }
}
