<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'caja';
    protected $primaryKey = 'idCaja';
    protected $fillable = ['descripcion', 'estado', 'vigencia'];
    public $timestamps = false;
    
    public function movimiento(){
        return $this->hasMany('App\MovimientoCaja');
    }
    public function ventas(){
        return $this->hasMany('App\Venta');
    }
}
