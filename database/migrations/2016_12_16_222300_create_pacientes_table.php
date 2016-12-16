<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('documento_identidad',9)->nullable();
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fecha_nacimiento');
            $table->string('direccion')->nullable();
            $table->string('genero',12);
            $table->string('telefono',8);
            $table->string('email')->nullable();
            $table->string('profesion')->nullable();
            $table->timestamps();
        });

        Schema::create('paciente_cliente', function (Blueprint $table) {
            $table->integer('paciente_id');
            $table->integer('cliente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['paciente_id','cliente_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paciente_cliente');
        Schema::dropIfExists('pacientes');
    }
}
