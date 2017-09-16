<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unique();
            $table->boolean('juridical_person')->default(false);
            $table->boolean('origin_center')->default(false);
            $table->char('nit', 14)->unique()->nullable();
            $table->char('nrc', 7)->unique()->nullable();
            $table->string('business', 127)->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        DB::statement('
        create or replace view customers_vw as
        select c.id, c.account_id, a.sucursal_id, a.identity_document, a.first_name, a.last_name,
        a.first_name||\' \'||coalesce(a.last_name,\'\') as name, a.phone_number, a.address, c.juridical_person, 
        c.origin_center, c.nit, c.nrc, c.business, a.comment, a.created_at, a.updated_at 
        from customers c join accounts a on c.account_id = a.id;
        ');

        DB::statement('
        create or replace view customers_nit_vw as select c.id, c.nit, c.nrc from customers c 
        where c.nit is not null and c.nrc is not null;
        ');

        //insert trigger
        DB::statement('
        create or replace function customers_insert_tg() returns trigger as
        $tg_customer$
        begin
            insert into accounts(sucursal_id, first_name, last_name, identity_document, phone_number, 
                address, comment, created_at, updated_at) values(new.sucursal_id, new.first_name, new.last_name, 
                new.identity_document, new.phone_number, new.address, new.comment, new.created_at, new.updated_at)
                returning id into new.account_id;
            insert into customers(account_id, juridical_person, origin_center, nit, nrc, business) 
                values(new.account_id, new.juridical_person, new.origin_center, new.nit, new.nrc, new.business)
                returning id into new.id;
            return new;
        end;
        $tg_customer$ 
        LANGUAGE plpgsql;
        ');

        DB::statement('
        create trigger customers_insert_tg instead of insert on customers_vw for each row
        EXECUTE PROCEDURE customers_insert_tg();
        ');

        //update trigger
        DB::statement('
        create or replace function customers_update_tg() returns trigger as
        $tg_customer$
        begin
            update customers set (juridical_person, origin_center, nit, nrc, business) = (new.juridical_person, 
            new.origin_center, new.nit, new.nrc, new.business) where id = old.id;
            update accounts set (sucursal_id, first_name, last_name, identity_document, phone_number, address,
            comment, updated_at) = (new.sucursal_id, new.first_name, new.last_name, new.identity_document, 
            new.phone_number, new.address, new.comment, new.updated_at) where id = old.account_id;
            return new;
        end;
        $tg_customer$ 
        LANGUAGE plpgsql;
        ');

        DB::statement('
        create trigger customers_update_tg instead of update on customers_vw for each row
        EXECUTE PROCEDURE customers_update_tg();
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop trigger customers_update_tg on customers_vw;');
        DB::statement('drop function customers_update_tg();');
        DB::statement('drop trigger customers_insert_tg on customers_vw;');
        DB::statement('drop function customers_insert_tg();');
        DB::statement('drop view customers_nit_vw;');
        DB::statement('drop view customers_vw;');
        Schema::dropIfExists('customers');
    }
}
