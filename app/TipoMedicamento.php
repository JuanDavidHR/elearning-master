<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMedicamento extends Model
{
    protected $table = 'tipo_medicamento';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'codigo' ,'nombre','vigencia'
    ];
    public $timestamps = false;
}
