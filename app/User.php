<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'id', 'usuario', 'password', 'idRoles', 'vigencia'
    ];
//comentar para ver el password
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;

    public function rol(){
        return $this->belongTo('App\Rol');
    }
    public function persona(){
        return $this->belongTo('App\Persona');
    }
    public function kardex(){
        return $this->belongsTo('App\Kardex');  
    }
    public function movimientos(){
        return $this->hasMany('App\MovimientoCaja');
    }
    public function ventas(){
        return $this->hasMany('App\Venta');
    }
}
