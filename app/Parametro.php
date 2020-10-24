<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'parametro';
    protected $primaryKey = 'idParametro';
    protected $fillable = [ 
        'nombreParametro', 
        'inicialParametro', 
        'vigenciaParametro'
    ];
    public function usuario(){
        return $this->belongsTo('App\User');
    }
    public function preveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
}
