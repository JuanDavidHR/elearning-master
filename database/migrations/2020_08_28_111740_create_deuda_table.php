<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeudaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deuda', function (Blueprint $table) {
            $table->increments('idDeuda');
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('entidad')->onDelete('cascade');
            $table->string('numRecibo', 11);
            $table->dateTime('fechaRegistro');
            $table->decimal('montoTotal', 11, 2);
            $table->decimal('montoCobrado', 11, 2);
            $table->decimal('montoDeuda', 11, 2);
            $table->string('descripcion', 90);
            $table->boolean('vigencia')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deuda');
    }
}
