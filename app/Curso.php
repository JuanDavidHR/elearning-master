<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'nombreCurso' ,'fechaCurso', 'horasCurso','vigencia'
    ];
    public $timestamps = false;
}
