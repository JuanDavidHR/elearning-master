<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingresos';//con qué tabla se trabaja
    protected $primaryKey = 'idIngreso';
    protected $fillable = [ 
        'idProveedor', 
        'idUsuario', 
        'tipoComprobante', 
        'serieComprobante',
        'numComprobante',
        'impuesto',
        'total',
        'fecha_compra',
        'estado'
    ];
    public function usuario(){
        return $this->belongsTo('App\User');
    }
    public function preveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
}
