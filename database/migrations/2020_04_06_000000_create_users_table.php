<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{ 
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('entidad')->onDelete('cascade');
            $table->string('usuario')->unique();
            $table->string('password');
            $table->integer('idroles')->unsigned();
            $table->foreign('idroles')->references('idRoles')->on('roles');
            $table->boolean('vigencia')->default(1);
            $table->rememberToken();
            //$table->timestamps();
        });
        DB::table('users')->insert(array('id'=>1, 'usuario'=>'admin', 'password' =>'$2y$10$k1z5uamav.Bl4BPV4HxdMe1.9sH1W3COwTJ0sutDJHBez9gPiSbb.', 'idroles'=>1, 'vigencia'=>1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
