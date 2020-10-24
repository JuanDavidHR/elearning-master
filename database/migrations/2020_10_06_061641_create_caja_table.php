<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja', function (Blueprint $table) {
            $table->increments('idCaja');
            $table->string('descripcion', 90);
            $table->boolean('estado')->default(0);
            $table->boolean('vigencia')->default(1);
        });
        DB::table('caja')->insert(array('idCaja'=>1, 'descripcion'=>'Caja Chica de la Empresa.'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caja');
    }
}
