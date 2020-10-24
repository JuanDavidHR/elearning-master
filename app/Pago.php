<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pago';
    protected $primaryKey = 'idPago';
    protected $fillable = ['idCuenta','descripcion','monto',
    'fecha','vigencia'];
}
