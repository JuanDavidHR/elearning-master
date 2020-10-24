<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detallePrecio extends Model
{
    protected $table = 'detalle_precio';
    protected $primaryKey = 'idDetalle';
    protected $fillable = [ 
        'idPrecio', 
        'idParametro', 
        'valor'
    ];
    public function precio(){
        return $this->belongsTo('App\Precio');
    }
    public function parametro()
    {
        return $this->belongsTo('App\Parametro');
    }
}
