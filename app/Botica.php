<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Botica extends Model
{
    protected $table = 'botica';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'codigo' ,'nombre','direccion','telefono','longitud','latitud','hapertura','hcierra','vigencia'
    ];
    public $timestamps = false;
}
