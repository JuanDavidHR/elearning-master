<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallaMedicamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalla_medicamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->string('registoSanitorio');
            $table->string('precio');
            $table->boolean('vigencia')->default(1);
            $table->integer('idMedicamento')->unsigned();
            $table->integer('idPresentacion')->unsigned();
            $table->integer('idTipo')->unsigned();
            $table->integer('idBotica')->unsigned();
            $table->integer('idLaboratorio')->unsigned();
            $table->foreign('idPresentacion')->references('id')->on('presentacion');
            $table->foreign('idMedicamento')->references('id')->on('medicamento');
            $table->foreign('idTipo')->references('id')->on('tipo_medicamento');
            $table->foreign('idBotica')->references('id')->on('botica');
            $table->foreign('idLaboratorio')->references('id')->on('laboratorio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalla_medicamento');
    }
}
