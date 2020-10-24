<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table = 'detalle_ingresos';//con qué tabla se trabaja
    protected $primaryKey = 'idDetalleIngreso';
    protected $fillable = [ 
        'idIngreso', 
        'idProducto', 
        'idLote', 
        'precio',
        'cantidad'
    ];
    public $timestamps = false;
}
