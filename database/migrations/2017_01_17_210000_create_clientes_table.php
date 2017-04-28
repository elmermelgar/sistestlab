<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('persona_juridica')->default(false);
            $table->boolean('centro_origen')->default(false);
            $table->string('razon_social');
            $table->string('dui',9)->nullable();
            $table->string('nit',14)->nullable();
            $table->string('nrc',7)->nullable();
            $table->string('giro')->nullable();
            $table->string('telefono',8);
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->string('descripcion')->nullable();
            $table->index('razon_social');
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
//            $table->unique('razon_social');
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
        Schema::dropIfExists('clientes');
    }
}
