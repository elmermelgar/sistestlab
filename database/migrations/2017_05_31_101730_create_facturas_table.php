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
            $table->integer('recolector_id')->nullable();
            $table->integer('estado_id');
            $table->integer('tax_credit_id')->nullable();
            $table->string('numero', 8)->nullable();
            $table->decimal('nivel', 3, 2)->default(0);
            $table->decimal('total')->default(0);
            $table->boolean('credito_fiscal')->default(false);
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->time('time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('recolector_id')->references('id')->on('recolectores');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('tax_credit_id')->references('id')->on('tax_credits');
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
