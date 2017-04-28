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
            $table->decimal('monto',6,2);
            $table->string('descripcion');
            $table->timestamps();
        });

        Schema::create('bono_recolector', function (Blueprint $table) {
            $table->integer('bono_id');
            $table->integer('recolector_id');
            $table->date('fecha');
            $table->foreign('bono_id')->references('id')->on('bonos')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recolector_id')->references('id')->on('recolectores')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['bono_id','recolector_id','fecha']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bono_recolector');
        Schema::dropIfExists('bonos');
    }
}
