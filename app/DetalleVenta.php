<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = 'idDetalle';
    protected $fillable = ['idVenta', 'idProducto', 'precioUnitario', 'moneda', 'totalProducto', 'cantidad', 'unidadMedida', 'estado', 'nombreProd',
'codigoProd', 'seVende', 'usaInventario', 'costo', 'ganancia'];
    public $timestamps = false;
    public function venta(){
        return $this->belongsTo('App\Venta');  
    }
}
