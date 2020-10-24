<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecepcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcion', function (Blueprint $table) {
            $table->increments('idRecepcion');
            $table->integer('id')->unsigned()->nullable();
            $table->foreign('id')->references('id')->on('entidad')->onDelete('cascade');
            $table->integer('sacosDevolucion')->default(0);
            $table->string('nombre', 90);
            $table->decimal('total', 11, 2);
            $table->decimal('cantidad', 11, 2);
            $table->string('estado', 90)->default('Revision');
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
        Schema::dropIfExists('recepcion');
    }
}
