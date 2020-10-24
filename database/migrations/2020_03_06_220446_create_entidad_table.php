<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('tipo_documento', 20)->nullable();
            $table->string('num_documento', 20)->unique();        
            $table->string('direccion', 70)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->boolean('vigencia')->default(1);
            $table->timestamps();
        });
        DB::table('entidad')->insert(array('nombre'=>'Administrador del Sitio', 'tipo_documento'=>'DNI', 'num_documento' =>'00000000', 'vigencia'=>0));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entidad');
    }
}
