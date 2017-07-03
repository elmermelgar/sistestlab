<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monto', 6, 2);
            $table->string('descripcion');
            $table->timestamps();
        });

        Schema::create('bono_recolector', function (Blueprint $table) {
            $table->integer('transaction_id');
            $table->integer('bono_id');
            $table->integer('recolector_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('bono_id')->references('id')->on('bonos')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recolector_id')->references('id')->on('recolectores')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['transaction_id', 'bono_id', 'recolector_id']);
        });

        DB::statement('
        create or replace view bono_recolector_vw as
        select t.id transaction_id, t.sucursal_id, b.bono_id, b.recolector_id, 
        t.amount, t.type, t.date from bono_recolector b join transactions t
        on b.transaction_id=t.id;
        ');

        DB::statement('
        create or replace function bono_recolector_tg() returns trigger as
        $BODY$
        declare
        transaction_id integer;
        begin
            transaction_id=(select nextval(\'transactions_id_seq\'::regclass));
            insert into transactions(id, sucursal_id, amount,type) values(transaction_id,new.sucursal_id,new.amount,new.type);
            insert into bono_recolector(transaction_id,bono_id,recolector_id) values(transaction_id,new.bono_id,new.recolector_id);
            return new;
        end;
        $BODY$ 
        LANGUAGE plpgsql;
        ');

        DB::statement('
        create trigger bono_recolector_tg instead of insert on bono_recolector_vw for each row
        EXECUTE PROCEDURE bono_recolector_tg();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop trigger bono_recolector_tg on bono_recolector_vw;');
        DB::statement('drop function bono_recolector_tg();');
        DB::statement('drop view bono_recolector_vw;');
        Schema::dropIfExists('bono_recolector');
        Schema::dropIfExists('bonos');
    }
}
