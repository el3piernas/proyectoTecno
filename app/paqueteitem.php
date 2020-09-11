<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paqueteitem extends Model
{
    protected $table = "paqueteitem";
    protected $fillable = [
       'idPaquete',
       'idItem',
       'cantidad',
       'precio'
       
    ];
    public $timestamps=false;
    public function reserva(){
        return $this->hasMany('App\reserva');
   }

   public function notaservicio(){
      return $this->hasMany('App\notaservicio');
   }
}
