<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxRegistryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_registry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sucursal_id');
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->time('time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('account_id')->nullable();
            $table->integer('state')->default(0);
            $table->decimal('cash', 8, 2)->default(0);
            $table->decimal('debit', 8, 2)->default(0);
            $table->decimal('debt', 8, 2)->default(0);
            $table->decimal('cost', 8, 2)->default(0);
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        // Añade restricción
        DB::statement('
        alter table box_registry add constraint chk_registry_amounts check 
        ( cash >= 0 and debit >= 0 and debt >= 0 and cost >= 0 );
        ');

        // Añade restricción de estado de caja
        DB::statement('
        create or replace function chk_registry_state() returns trigger as $func$
        declare state integer;
         begin
            select b.state from box_registry b order by date desc, time desc limit 1 into state;
            if new.state=state then 
                raise exception \'No se puede registrar un estado de caja igual que el anterior: %\', new.state;
            end if;
            return new;
         end;
         $func$
         language plpgsql;
        ');

        // Añade restricción de estado de caja
        DB::statement('
        create trigger chk_registry_states before insert or update on box_registry
            for each row execute procedure chk_registry_state();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('box_registry');
    }
}
