<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaservicio extends Model
{
    protected $table = "notaservicio";
    protected $fillable=[
         'idCliente',
         'idEmpleado',
         'idSalon',
         'idPaqueteItem',
         'fecha',
         'horaInicio',
         'horaFin',
         'montoTotal',
         'estado'
        
    ];
    public $timestamps=false;
    public function cliente(){
        return $this->belongsTo('App\cliente');
     } 

     public function empleado(){
        return $this->belongsTo('App\empleado');
     } 

     public function salon(){
        return $this->belongsTo('App\salon');
     } 

     public function paqueteitem(){
        return $this->belongsTo('App\paqueteitem');
     } 
}
