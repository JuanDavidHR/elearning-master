<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago', function (Blueprint $table) {
            $table->increments('idPago');
            $table->integer('idCuenta')->unsigned();
            $table->foreign('idCuenta')->references('idCuenta')->on('cuenta')->onDelete('cascade');
            $table->string('descripcion', 90);
            $table->decimal('monto', 11, 2);
            $table->dateTime('fecha');
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
        Schema::dropIfExists('pago');
    }
}
