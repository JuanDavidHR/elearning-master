<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'entidad';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','DNI','direccion','telefono','email','vigencia'];

    Public function proveedor(){
        return $this->hasOne('App\Proveedor');
    }
    public function user(){
        return $this->hasOne('app\User');
    }
}

