<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fiel extends Model
{
    protected $table = 'fiel';
    protected $primaryKey = 'idFiel';
    protected $fillable = [
        'documento_remision',
        'fecha_remision', 
        'fecha_recepcion', 
        'contrato',
        'monto_contrato', 
        'monto_garantia', 
        'fecha_inicio_garantia',
        'fecha_termino_garantia', 
        'fecha_inicio_contrato', 
        'fecha_termino_contrato',
        'monto_adicional_1',
        'monto_adicional_2',
        'monto_adicional_3',
        'monto_reduccion',
        'fecha_termino_ampliacion',
        'vigencia'
    ];
}
