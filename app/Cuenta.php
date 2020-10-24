<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuenta';
    protected $primaryKey = 'idCuenta';
    protected $fillable = ['id','tipo','nombre', 'saldo','categoria',
    'montoTotal','montoPagado','estado','vigencia'];
    /* Ccategorias -> Serviocos, Préstamos, compras */
}
