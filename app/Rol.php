<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'idRoles';
    protected $fillable = ['nombre', 'descripcion', 'vigencia'];
    public $timestamps = false;
    public function users(){
        return $this->hasMany('App\User');
    }
}
