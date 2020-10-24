<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalleRecepcion extends Model
{
    protected $table = 'detalle_recepcion';
    protected $primaryKey = 'idDetalleRecepcion';
    protected $fillable = [ 
        'idRecepcion', 
        'idAlmacen', 
        'nombre', 
        'estado',
        'codigo',
        'modal', 
        'saco', 
        'kilo', 
        'tara', 
        'kiloNeto', 
        'QQ', 
        'c',
        'r',
        'h',
        'precioQQ',
        'total',
        'vigencia',
    ];
}
