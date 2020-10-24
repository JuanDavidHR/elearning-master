<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lote';
    protected $primaryKey = 'idLote';
        protected $fillable = [ 
        'tipoCafe',
        'codigoLote', 
        'nombreLote', 
        'sacosLote',
        'quintalesLote',
        'taraLote',
        'pesoNetoQuintal',
        'cLote',
        'rLote',
        'hLote',
        'precioNetoQuintal',
        'quintalesPromedio',
        'precioCompra',
        'inversion',
        'quintalesGanancia',
        'precioVenta',
        'ingresoVenta',
        'estado'
    ];
}
