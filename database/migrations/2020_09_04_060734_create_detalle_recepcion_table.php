<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleRecepcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_recepcion', function (Blueprint $table) {
            $table->increments('idDetalleRecepcion');
            $table->integer('idRecepcion')->unsigned();
            $table->foreign('idRecepcion')->references('idRecepcion')->on('recepcion');
            $table->integer('idAlmacen')->unsigned()->nullable();
            $table->foreign('idAlmacen')->references('idAlmacen')->on('almacen');
            $table->string('nombre');
            $table->string('tipo');
            $table->string('estado')->nullable();
            $table->string('codigo')->nullable();
            $table->string('modal');
            $table->decimal('saco', 11, 2);
            $table->decimal('kilo', 11, 2);
            $table->decimal('tara', 11, 2);
            $table->decimal('kiloNeto', 11, 2);
            $table->decimal('QQ', 11, 2);
            $table->integer('c')->nullable();
            $table->integer('r')->nullable();
            $table->integer('h')->nullable();
            $table->decimal('precioQQ', 11, 2);
            $table->decimal('total', 11, 2);
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
        Schema::dropIfExists('detalle_recepcion');
    }
}
