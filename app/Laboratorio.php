<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = 'laboratorio';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'codigo' ,'nombre','vigencia'
    ];
    public $timestamps = false;
}
