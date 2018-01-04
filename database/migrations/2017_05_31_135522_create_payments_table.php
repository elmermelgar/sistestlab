<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('transaction_id');
            $table->integer('factura_id');
            $table->primary(['transaction_id', 'factura_id']);
            $table->foreign('transaction_id')->references('id')->on('transactions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('factura_id')->references('id')->on('facturas')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        DB::statement('
        create or replace view payments_vw as
        select t.sucursal_id, t.id transaction_id, p.factura_id , t.amount, t.type, t.date, t.time from payments p 
        join transactions t on p.transaction_id=t.id;
        ');

        DB::statement('
        create or replace function payments_tg() returns trigger as
        $tg_pago$
        declare
            transaction_id integer;
        begin
            insert into transactions(sucursal_id,amount,type) 
                values(new.sucursal_id,new.amount,new.type) returning id into transaction_id;
            insert into payments(transaction_id,factura_id) values(transaction_id,new.factura_id);
            return new;
        end;
        $tg_pago$ 
        LANGUAGE plpgsql;
        ');

        DB::statement('
        create trigger payments_tg instead of insert on payments_vw for each row
        EXECUTE PROCEDURE payments_tg();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop trigger payments_tg on payments_vw;');
        DB::statement('drop function payments_tg();');
        DB::statement('drop view payments_vw;');
        Schema::dropIfExists('payments');
    }
}
