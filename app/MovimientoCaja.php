<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $table = 'movimiento_caja';
    protected $primaryKey = 'idMovimiento';
    protected $fillable = ['idCaja', 'id', 'fechaApertura', 'fechaCierre', 'ingresos', 'egresos', 'dineroInicial', 'totalCalculado', 'totalReal', 'estado', 'diferencia', 'vigencia'];
    public $timestamps = false;
    public function caja(){
        return $this->belongsTo('App\Caja');  
    }
    public function usuario(){
        return $this->belongsTo('App\User');  
    }
}
