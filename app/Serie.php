<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'serie';
    protected $primaryKey = 'idSerie';
    protected $filleable = [
        'idLote', 'serie', 'fechaGarantia', 'vigencia'
    ];
    public function lote(){
        return $this->belongsTo('App\lote');  
    }
}
