<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table = 'medicamento';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'codigo' ,'nombre','vigencia','idTipoMedicamento'
    ];
    public $timestamps = false;
}
