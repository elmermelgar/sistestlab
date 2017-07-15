<?php

use Illuminate\Support\Facades\DB;
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
            $table->string('dui', 9)->nullable();
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fecha_nacimiento');
            $table->string('direccion')->nullable();
            $table->string('genero', 12);
            $table->string('telefono', 8);
            $table->string('email')->nullable();
            $table->string('profesion')->nullable();
            $table->string('observacion')->nullable();
            $table->string('procedencia')->nullable();
            $table->timestamps();
        });

        Schema::create('paciente_cliente', function (Blueprint $table) {
            $table->integer('paciente_id');
            $table->integer('cliente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['paciente_id', 'cliente_id']);
        });

        DB::statement('
        create or replace view pacientes_vw as
        select p.id, p.nombre||\' \'||p.apellido full_name, p.dui, p.genero, 
        extract(year from age(fecha_nacimiento)) edad from pacientes p;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view pacientes_vw;');
        Schema::dropIfExists('paciente_cliente');
        Schema::dropIfExists('pacientes');
    }
}
