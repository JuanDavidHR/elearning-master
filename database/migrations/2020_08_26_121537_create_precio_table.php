<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio', function (Blueprint $table) {
            $table->increments('idPrecio');
            $table->string('codigoGenerate')->unique();
            $table->decimal('precioCompra', 11, 2);
            $table->decimal('precioVenta', 11, 2);
            $table->integer('c');
            $table->integer('h');
            $table->integer('r');
            $table->string('unidad')->default('Quintal');
            $table->timestamps();
        });
        DB::table('precio')->insert(array('idPrecio'=>1, 'codigoGenerate'=>'030030030', 'precioCompra'=>120, 'precioVenta'=>140, 'c'=>30, 'h'=>30, 'r'=>30));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precio');
    }
}
