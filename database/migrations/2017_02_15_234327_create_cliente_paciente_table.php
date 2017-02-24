<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientePacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('cliente_paciente', function (Blueprint $table) {
            $table->integer('cliente_id')->unsigned();
            $table->integer('paciente_id')->unsigned();
            $table->boolean('same_record')->default(false);

            $table->foreign('cliente_id')->references('id')->on('clientes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['cliente_id', 'paciente_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cliente_paciente');
    }
}
