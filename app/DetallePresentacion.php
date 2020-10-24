<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePresentacion extends Model
{
    protected $table = 'detalle_presentacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'codigo' ,'vigencia','idPresentacion','idMedicamento'
    ];
    public $timestamps = false;
}
