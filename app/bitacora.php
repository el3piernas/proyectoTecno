<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bitacora extends Model
{
    protected $table = "bitacora";
    protected $fillable = [
        'idEmpleado',
        'fecha',
        'hora',
        'tabla',
        'codigoTabla',
        'transaccion'
        
    ];
    public $timestamps=false;
    public function empleado(){
        return $this->belongsTo('App\empleado');
    }
}
