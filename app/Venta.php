<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'idVenta';
    protected $fillable = ['idPersona', 'idUsuario', 'fechaVenta', 'numeroDoc', 'montoTotal', 'tipoPago', 'estado', 'comprobante', 'fechaPago',
'accion', 'pagoCon', 'vuelto', 'porcentaje', 'idCaja'];
    public $timestamps = false;
    
    public function venta(){
        return $this->belongsTo('App\User');  
    }
    public function caja(){
        return $this->belongsTo('App\Caja');  
    }
    public function detalles(){
        return $this->hasMany('App\DetalleVenta');
    }

}
