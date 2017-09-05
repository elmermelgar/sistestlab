<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factura_id');
            $table->integer('profile_id');
            $table->decimal('price', 8, 2)->default(0);
            $table->foreign('factura_id')->references('id')->on('facturas');
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_profile');
    }
}
