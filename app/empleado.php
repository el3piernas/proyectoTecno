<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empleado extends Model
{
    protected $table = "empleado";
    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'telefono',
        'usuario',
        'password'
    ];
    public $timestamps=false;
    public function bitacora(){
        return $this->hasMany('App\bitacora');
    }

    public function notaservicio(){
        return $this->hasMany('App\notaservicio');
    }
}
