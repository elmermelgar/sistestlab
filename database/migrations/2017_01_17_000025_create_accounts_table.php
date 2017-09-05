<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sucursal_id');
            $table->string('first_name', 127);
            $table->string('last_name', 127)->nullable();
            $table->char('identity_document', 9)->unique()->nullable();
            $table->char('phone_number', 8);
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('seal')->nullable();
            $table->string('comment')->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->timestamps();
        });

        DB::statement('
        create or replace function accounts_update_tg() returns trigger as
        $tg_accounts$
        begin
            update users set name = new.first_name||\' \'||new.last_name where account_id=new.id;
            return new;
        end;
        $tg_accounts$ 
        LANGUAGE plpgsql;
        ');

        DB::statement('
        create trigger accounts_update_tg after update of first_name, last_name on accounts for each row
        EXECUTE PROCEDURE accounts_update_tg();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop trigger accounts_update_tg on accounts;');
        DB::statement('drop function accounts_update_tg();');
        Schema::drop('accounts');
    }
}
