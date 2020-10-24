<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacen';
    protected $primaryKey = 'idAlmacen';
    protected $fillable = [ 
        'codigoAlmacen',
        'nombreAlmacen',
        'tipoCafe',
        'tipoAlmacen',
        'cAlmacen',
        'rAlmacen',
        'hAlmacen',
        'sacosAlmacen',
        'taraAlmacen',
        'pesoKg',
        'pesoNetoKg',
        'pesoNetoQuintal',
        'precioCompra',
        'precioVenta',
        'inversion',
        'vigencia'
    ];
}
