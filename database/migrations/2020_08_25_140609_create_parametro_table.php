<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametro', function (Blueprint $table) {
            $table->increments('idParametro');
            $table->string('nombreParametro', 50)->unique();
            $table->string('inicialParametro', 10)->unique();
            $table->integer('minParametro');
            $table->integer('maxParametro');
            $table->boolean('vigenciaParametro')->default(1);
            $table->timestamps();
        });
        DB::table('parametro')->insert(array('idParametro'=>1, 'nombreParametro'=>'Cáscara', 'inicialParametro' =>'C', 'minParametro' => 15, 'maxParametro' => 60));
        DB::table('parametro')->insert(array('idParametro'=>2, 'nombreParametro'=>'Rendimiento', 'inicialParametro' =>'R', 'minParametro' => 30, 'maxParametro' => 80));
        DB::table('parametro')->insert(array('idParametro'=>3, 'nombreParametro'=>'Humedad', 'inicialParametro' =>'H', 'minParametro' => 9, 'maxParametro' => 30));
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametro');
    }
}
