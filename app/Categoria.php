<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';//con qué tabla se trabaja
    protected $primaryKey = 'id';//nombre de la Columna, por defecto es id pero si le cambias de nombre en los parentesis debe de ir el nombre que le pusiste
    protected $fillable = ['nombreCategoria', 'descripcion', 'vigencia'];//son los campos que se asignan valores en masa
    public $timestamps = false;
    
}
