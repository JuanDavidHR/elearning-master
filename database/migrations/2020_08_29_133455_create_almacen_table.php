<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacen', function (Blueprint $table) {
            $table->increments('idAlmacen');
            $table->string('codigoAlmacen', 15)->unique();
            $table->string('nombreAlmacen', 80);
            $table->string('tipoCafe', 80);
            $table->string('tipoAlmacen', 80);
            $table->decimal('cAlmacen', 11, 2)->default(0);
            $table->decimal('rAlmacen', 11, 2)->default(0);
            $table->decimal('hAlmacen', 11, 2)->default(0);
            $table->decimal('sacosAlmacen', 11, 2)->default(0);
            $table->decimal('taraAlmacen', 11, 2)->default(0);
            $table->decimal('pesoKg', 11, 2)->default(0);
            $table->decimal('pesoNetoKg', 11, 2)->default(0);
            $table->decimal('pesoNetoQuintal', 11, 2)->default(0);
            $table->decimal('precioCompra', 11, 2)->default(0);
            $table->decimal('precioVenta', 11, 2)->default(0);
            $table->decimal('inversion', 11, 2)->default(0);
            $table->boolean('vigencia')->default(1);
            $table->timestamps();
        });
        
        DB::table('almacen')->insert(array('idAlmacen'=>1, 'codigoAlmacen'=>'C01', 'nombreAlmacen' =>'Ruma Café Comercial', 'tipoCafe'=>'comercial', 'tipoAlmacen'=>'Ruma'));
        DB::table('almacen')->insert(array('idAlmacen'=>2, 'codigoAlmacen'=>'C02', 'nombreAlmacen' =>'Lote Café Comercial', 'tipoCafe'=>'comercial', 'tipoAlmacen'=>'Lote'));
        DB::table('almacen')->insert(array('idAlmacen'=>3, 'codigoAlmacen'=>'C03', 'nombreAlmacen' =>'Ruma Café Corriente', 'tipoCafe'=>'corriente', 'tipoAlmacen'=>'Ruma'));
        DB::table('almacen')->insert(array('idAlmacen'=>4, 'codigoAlmacen'=>'C04', 'nombreAlmacen' =>'Lote Café Corriente', 'tipoCafe'=>'corriente', 'tipoAlmacen'=>'Lote'));
        DB::table('almacen')->insert(array('idAlmacen'=>5, 'codigoAlmacen'=>'C05', 'nombreAlmacen' =>'Lote Café Orgánico', 'tipoCafe'=>'orgánico', 'tipoAlmacen'=>'Lote'));
        DB::table('almacen')->insert(array('idAlmacen'=>6, 'codigoAlmacen'=>'C06', 'nombreAlmacen' =>'Lote Café Coco', 'tipoCafe'=>'coco', 'tipoAlmacen'=>'Lote'));
        DB::table('almacen')->insert(array('idAlmacen'=>7, 'codigoAlmacen'=>'C07', 'nombreAlmacen' =>'Lote Café Cashapa', 'tipoCafe'=>'cashapa', 'tipoAlmacen'=>'Lote'));
        DB::table('almacen')->insert(array('idAlmacen'=>8, 'codigoAlmacen'=>'C08', 'nombreAlmacen' =>'Lote Cacao', 'tipoCafe'=>'cacao', 'tipoAlmacen'=>'Lote'));
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('almacen');
    }
}
