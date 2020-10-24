<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('entidad')->onDelete('cascade');
            $table->string('zona', 50)->nullable();
        });
        DB::table('proveedores')->insert(array('id'=>'1', 'zona'=>'Sin Zona'));
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
