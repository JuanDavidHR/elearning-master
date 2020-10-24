<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('idRoles');
            $table->string('nombre', 30)->unique();
            $table->string('descripcion', 100)->nullable();
            $table->boolean('vigencia')->default(1);            
        });
        //así se hacen las insercciones a la hora de crear
        DB::table('roles')->insert(array('idRoles'=>'1', 'nombre'=>'Administrador del sistema', 'descripcion' =>'Administradores del Sistema Web.'));
        DB::table('roles')->insert(array('idRoles'=>'2', 'nombre'=>'Cajero', 'descripcion' =>'Paga y cobra'));
        DB::table('roles')->insert(array('idRoles'=>'3', 'nombre'=>'Almacenero', 'descripcion' =>'Registra y recibe materia prima.'));
    }

   
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
