<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'idArea';
    protected $fillable = ['nombre', 'vigencia'];
    
    public function encargos(){
        return $this->hasMany('App\Encargo');  
    }
    public function viaticos(){
        return $this->hasMany('App\Encargo');  
    }
}
