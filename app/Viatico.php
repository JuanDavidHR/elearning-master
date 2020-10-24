<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viatico extends Model
{
    protected $table = 'viatico';
    protected $primaryKey = 'idViatico';
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
        'monto_viatico', 
        'vigencia'
    ];
    public function area(){
        return $this->belongsTo('App\Area');
    }
}
