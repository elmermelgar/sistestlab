<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('customer_patient', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['customer_id', 'patient_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customer_patient');
    }
}
