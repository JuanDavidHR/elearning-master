<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encargo extends Model
{
    protected $table = 'encargo';
    protected $primaryKey = 'idEncargo';
    protected $fillable = [
        'idArea',
        'fecha_solicitud', 
        'fecha_autorizacion', 
        'fecha_inicio',
        'fecha_final', 
        'fecha_maximo', 
        'documento_solicitud', 
        'tipo_actividad', 
        'documento_autorizacion', 
        'nombre_responsable', 
        'monto_encargo', 
        'vigencia'
    ];
    public function area(){
        return $this->belongsTo('App\Area');
    }
}
