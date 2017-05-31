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
            $table->timestamp('stamp');
            $table->integer('user_id')->nullable();
            $table->integer('estado');
            $table->decimal('efectivo', 8, 2)->default(0);
            $table->decimal('debito', 8, 2)->default(0);
            $table->decimal('deuda', 8, 2)->default(0);
            $table->primary(['sucursal_id', 'stamp']);
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('user_id')->references('id')->on('users');
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
