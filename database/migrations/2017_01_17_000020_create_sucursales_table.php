<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name');
            $table->string('direccion');
            $table->string('telefono', 8)->nullable();
            $table->integer('imagen_id')->nullable();
            $table->foreign('imagen_id')->references('id')->on('imagenes');
            $table->timestamps();
        });

        DB::statement('
        create or replace function check_branch(s_id int) returns void as $$
        declare
            sucursal int;
        begin
            select id from sucursales where id=s_id into sucursal;
            if not found then
                raise exception \'La sucursal especificada no existe\';
            end if;
        end
        $$ language plpgsql;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop function check_branch(int)');
        Schema::dropIfExists('sucursales');
    }
}
