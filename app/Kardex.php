<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    protected $table = 'kardex';
    protected $primaryKey = 'idKardex';
    protected $filleable = [
        'idAlmacen', 
        'idUser', 
        'fecha', 
        'motivo', 
        'tipo', 
        'qTipo', 
        'cuTipo', 
        'ctTipo', 
        'qSaldo', 
        'cuSaldo', 
        'ctSaldo',
        'vigencia'
    ];
}
