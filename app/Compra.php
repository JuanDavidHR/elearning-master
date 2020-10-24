<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compra';
    protected $primaryKey = 'idCompra';
    protected $fillable = ['idUser','idRecepcion','fechaCompra',
    'total','nombre','observacion','estado','vigencia'];
}
