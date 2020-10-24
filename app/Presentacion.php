<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    protected $table = 'presentacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'codigo' ,'nombre','vigencia'
    ];
    public $timestamps = false;
}