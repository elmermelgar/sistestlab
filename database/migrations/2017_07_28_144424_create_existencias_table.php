<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('existencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sucursal_id');
            $table->integer('activo_id');
            $table->date('fecha_adquisicion');
            $table->date('fecha_vencimiento');
            $table->integer('cantidad');
            $table->string('lote');
            $table->decimal('precio', 10, 2);
            $table->foreign(['sucursal_id', 'activo_id'])->references(['sucursal_id', 'activo_id'])->on('inventarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('existencias');
    }
}
