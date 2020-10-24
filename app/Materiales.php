<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
    protected $table = 'materiales';
    protected $primaryKey = 'idMateriales';
    protected $fillable = [
        'documento_remision',
        'fecha_remision', 
        'fecha_recepcion', 
        'contrato',
        'monto_contrato', 
        'obra', 
        'fecha_inicio_plazo',
        'fecha_termino_plazo', 
        'monto_adelanto_1', 
        'monto_adelanto_2',
        'monto_adelanto_3',
        'monto_adelanto_4',
        'fecha_desde_adelanto_1',
        'fecha_desde_adelanto_2',
        'fecha_desde_adelanto_3',
        'fecha_desde_adelanto_4',
        'fecha_hasta_adelanto_1',
        'fecha_hasta_adelanto_2',
        'fecha_hasta_adelanto_3',
        'fecha_hasta_adelanto_4',
        'fecha_reporte',
        'vigencia'
    ];
}
