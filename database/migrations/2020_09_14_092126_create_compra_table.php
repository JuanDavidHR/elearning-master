<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra', function (Blueprint $table) {
            $table->increments('idCompra');
            $table->integer('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('entidad')->onDelete('cascade');
            $table->integer('idRecepcion')->unsigned()->nullable();
            $table->foreign('idRecepcion')->references('idRecepcion')->on('recepcion')->onDelete('cascade');
            $table->dateTime('fechaCompra');
            $table->decimal('total', 11, 2);
            $table->string('nombre', 30);
            $table->string('observacion', 90)->nullable();
            $table->string('estado', 30);
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
        Schema::dropIfExists('compra');
    }
}
