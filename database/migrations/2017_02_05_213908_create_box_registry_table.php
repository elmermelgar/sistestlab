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
            $table->integer('sucursal_id');
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->time('time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('account_id')->nullable();
            $table->integer('state')->default(0);
            $table->decimal('cash', 8, 2)->default(0);
            $table->decimal('debit', 8, 2)->default(0);
            $table->decimal('debt', 8, 2)->default(0);
            $table->decimal('cost', 8, 2)->default(0);
            $table->primary(['sucursal_id', 'date', 'time']);
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
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
