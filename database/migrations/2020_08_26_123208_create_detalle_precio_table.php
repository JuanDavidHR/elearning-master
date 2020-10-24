<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallePrecioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_precio', function (Blueprint $table) {
            $table->increments('idDetalle');
            $table->integer('idPrecio')->unsigned();
            $table->foreign('idPrecio')->references('idPrecio')->on('precio');
            $table->integer('idParametro')->unsigned();
            $table->foreign('idParametro')->references('idParametro')->on('parametro');
            $table->integer('valor');
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
        Schema::dropIfExists('detalle_precio');
    }
}
