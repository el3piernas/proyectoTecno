<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salon extends Model
{
    protected $table = "salon";
    protected $fillables = [
        'foto',
        'nombre',
        'descripcion',
        'ubicacion',
        'estado'
    ];
    public $timestamps=false;
    public function reserva(){
        return $this->hasMany('App\reserva');
   }

   public function notaservicio(){
    return $this->hasMany('App\notaservicio');
   }
}
