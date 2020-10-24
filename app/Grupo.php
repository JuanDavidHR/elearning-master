<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $primaryKey = 'idGrupos';
    protected $fillable = [
        'nombreGrupo',
        'descripcionGrupo',
        'inicialGrupo',
        'vigenciaGrupo'
    ];
}
