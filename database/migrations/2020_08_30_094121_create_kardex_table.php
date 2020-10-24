<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->increments('idKardex');
            $table->integer('idAlmacen')->unsigned();
            $table->foreign('idAlmacen')->references('idAlmacen')->on('almacen');
            $table->integer('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('users');
            $table->dateTime('fecha');
            $table->string('motivo', 50);
            $table->string('tipo', 40);
            $table->decimal('qTipo', 11, 3);
            $table->decimal('cuTipo', 11, 3);
            $table->decimal('ctTipo', 11, 3);
            $table->decimal('qSaldo', 11, 3);
            $table->decimal('cuSaldo', 11, 3);
            $table->decimal('ctSaldo', 11, 3);
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
        Schema::dropIfExists('kardex');
    }
}
