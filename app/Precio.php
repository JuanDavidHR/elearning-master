<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    protected $table = 'precio';
    protected $primaryKey = 'idPrecio';
    protected $fillable = [ 
        'codigoGenerate', 
        'precioCompra', 
        'c',
        'h',
        'r',
        'precioVenta',
        'unidad'
    ];
}
