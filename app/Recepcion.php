<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model
{
    protected $table = 'recepcion';
    protected $primaryKey = 'idRecepcion';
    protected $fillable = [ 
        'id',
        'nombre', 
        'sacosDevolucion',
        'total', 
        'cantidad',
        'estado',
        'vigencia'
    ];
}
