<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unique();
            $table->date('birth_date');
            $table->char('sex', 1);
            $table->string('profession',127)->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        DB::statement('
        create or replace view patients_vw as
        select p.id, p.account_id, a.sucursal_id, a.identity_document, a.first_name, a.last_name,
        a.first_name||\' \'||coalesce(a.last_name,\'\') as name, a.phone_number, a.address, p.birth_date, 
        p.sex, p.profession, a.comment, a.created_at, a.updated_at 
        from patients p join accounts a on p.account_id = a.id;
        ');

        DB::statement('
        create or replace view patients_search_vw as
        select p.id, a.identity_document, a.first_name||\' \'||a.last_name as name, p.sex, 
        extract(year from age(birth_date)) age from patients p join accounts a on p.account_id = a.id;
        ');

        //insert trigger
        DB::statement('
        create or replace function patients_insert_tg() returns trigger as
        $tg_patients$
        begin
            if new.account_id is null then
            insert into accounts(sucursal_id, first_name, last_name, identity_document, phone_number, 
                address, comment, created_at, updated_at) values(new.sucursal_id, new.first_name, new.last_name, 
                new.identity_document, new.phone_number, new.address, new.comment, new.created_at, new.updated_at)
                returning id into new.account_id;
            end if;
            insert into patients(account_id, birth_date, sex, profession) 
                values(new.account_id, new.birth_date, new.sex, new.profession)
                returning id into new.id;
            return new;
        end;
        $tg_patients$ 
        LANGUAGE plpgsql;
        ');

        DB::statement('
        create trigger patients_insert_tg instead of insert on patients_vw for each row
        EXECUTE PROCEDURE patients_insert_tg();
        ');

        //update trigger
        DB::statement('
        create or replace function patients_update_tg() returns trigger as
        $tg_patients$
        begin
            if new.account_id is not null then
            update accounts set (sucursal_id, first_name, last_name, identity_document, phone_number, 
                address, comment, updated_at) = (new.sucursal_id, new.first_name, new.last_name, new.identity_document, 
                new.phone_number, new.address, new.comment, new.updated_at) where id = old.account_id;
            end if;
            update patients set (birth_date, sex, profession) = (new.birth_date, new.sex, new.profession) 
                where id = old.id;
            return new;
        end;
        $tg_patients$ 
        LANGUAGE plpgsql;
        ');

        DB::statement('
        create trigger patients_update_tg instead of update on patients_vw for each row
        EXECUTE PROCEDURE patients_update_tg();
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop trigger patients_update_tg on patients_vw;');
        DB::statement('drop function patients_update_tg();');
        DB::statement('drop trigger patients_insert_tg on patients_vw;');
        DB::statement('drop function patients_insert_tg();');
        DB::statement('drop view patients_search_vw;');
        DB::statement('drop view patients_vw;');
        Schema::dropIfExists('patients');
    }
}
