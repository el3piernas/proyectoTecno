<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $table="cliente";
    protected $fillable=[
        'nombre',
        'apellido',
        'ci',
        'direccion',
        'telefono',
        'usuario',
        'password'
    ];
    public $timestamps=false;
    public function reserva(){
        return $this->hasMany('App\reserva');
   }

   public function notaservicio(){
    return $this->hasMany('App\notaservicio');
    }
}
