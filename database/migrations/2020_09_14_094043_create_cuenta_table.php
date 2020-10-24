<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta', function (Blueprint $table) {
            $table->increments('idCuenta');
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('entidad')->onDelete('cascade');
            $table->string('tipo', 30);
            $table->string('nombre', 30);
            $table->string('categoria', 30);
            $table->decimal('montoTotal', 11, 2);
            $table->decimal('montoPagado', 11, 2);
            $table->decimal('saldo', 11, 2);
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
        Schema::dropIfExists('cuenta');
    }
}
