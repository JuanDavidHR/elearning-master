<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleMedicamento extends Model
{
    protected $table = 'detalla_medicamento';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'codigo' ,'vigencia','idMedicamento','idPresentacion','idTipo','idBotica','idLaboratorio'
    ];
    public $timestamps = false;
}
