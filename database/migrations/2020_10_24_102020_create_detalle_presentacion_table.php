<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallePresentacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_presentacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->boolean('vigencia')->default(1);
            $table->integer('idPresentacion')->unsigned();
            $table->integer('idMedicamento')->unsigned();
            $table->foreign('idPresentacion')->references('id')->on('presentacion');
            $table->foreign('idMedicamento')->references('id')->on('medicamento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_presentacion');
    }
}
