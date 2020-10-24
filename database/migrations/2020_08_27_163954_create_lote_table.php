<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lote', function (Blueprint $table) {
            $table->increments('idLote');
            $table->string('codigoLote', 15)->unique();
            $table->string('nombreLote', 80);
            $table->string('tipoCafe', 80);
            $table->string('modal', 10);
            $table->decimal('sacosLote', 11, 2)->default(0);
            $table->decimal('quintalesLote', 11, 2)->default(0);
            $table->decimal('taraLote', 11, 2)->default(0);
            $table->decimal('pesoNetoQuintal', 11, 2)->default(0);
            $table->decimal('cLote', 11, 2)->default(0);
            $table->decimal('rLote', 11, 2)->default(0);
            $table->decimal('hLote', 11, 2)->default(0);
            $table->decimal('precioNetoQuintal', 11, 2)->default(0);
            $table->decimal('quintalesPromedio', 11, 2)->default(0);
            $table->decimal('precioCompra', 11, 2)->default(0);
            $table->decimal('inversion', 11, 2)->default(0);
            $table->decimal('quintalesGanancia', 11, 2)->default(0);
            $table->decimal('precioVenta', 11, 2)->default(0);
            $table->decimal('ingresoVenta', 11, 2)->default(0);
            $table->string('estado', 30)->default('Recibiendo');
            $table->timestamps();
        });
        DB::table('lote')->insert(array('idLote'=>1, 'codigoLote'=>'C01', 'nombreLote' =>'Almacén Café Orgánico', 'tipoCafe'=>'organico', 'modal'=>'organico'));
        DB::table('lote')->insert(array('idLote'=>2, 'codigoLote'=>'C02', 'nombreLote' =>'Almácen Café Cashapa', 'tipoCafe'=>'cashapa', 'modal'=>'cashapa'));
        DB::table('lote')->insert(array('idLote'=>3, 'codigoLote'=>'C03', 'nombreLote' =>'Almacén Café Coco', 'tipoCafe'=>'coco', 'modal'=>'coco'));
        DB::table('lote')->insert(array('idLote'=>4, 'codigoLote'=>'C04', 'nombreLote' =>'Almacén Cacao', 'tipoCafe'=>'cacao', 'modal'=>'cacao'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lote');
    }
}
