<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_caja', function (Blueprint $table) {
            $table->increments('idMovimiento');
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('entidad')->onDelete('cascade');
            $table->integer('idCaja')->unsigned();
            $table->foreign('idCaja')->references('idCaja')->on('caja')->onDelete('cascade');
            $table->dateTime('fechaApertura');
            $table->dateTime('fechaCierre')->nullable();
            $table->decimal('ingresos', 11, 2)->default(0);
            $table->decimal('egresos', 11, 2)->default(0);
            $table->decimal('dineroInicial', 11, 2);
            $table->decimal('totalCalculado', 11, 2)->default(0);
            $table->decimal('totalReal', 11, 2)->default(0);
            $table->string('estado', 40)->default('Apertura');
            $table->decimal('diferencia', 11, 2)->default(0);
            $table->boolean('vigencia')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimiento_caja');
    }
}
