<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    protected $table = 'deuda';
    protected $primaryKey = 'idDeuda';
    protected $fillable = ['id','numRecibo','fechaRegistro','montoTotal','montoCobrado','montoDeuda','descripcion','vigencia'];
}
