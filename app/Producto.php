<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';//con qué tabla se trabaja
    protected $primaryKey = 'idProducto';//nombre de la Columna, por defecto es id pero si le cambias de nombre en los parentesis debe de ir el nombre que le pusiste
    protected $filleable = [
        'idCategoria',
        'codigoProducto',
        'nombre', 
        'precioVenta', 
        'tipoVenta', 
        'descripcion',
        'precioCompra', 
        'stockMinimo', 
        'usaInventario', 
        'precioMayor', 
        'stock', 
        'usaSerie', 
        'vigencia'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');// id Categoria
    }
    public function lotes(){
        return $this->hasMany('App\Lote');  
    }
    public function kardex(){
        return $this->hasMany('App\Kardex');
    }
}
