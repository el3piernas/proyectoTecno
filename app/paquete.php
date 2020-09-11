<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paquete extends Model
{
    protected $table = "paquete";
    protected $fillable = [ 
     'idTipoPaquete',
     'acontecimiento',
     'precio',
     
    ];
    public $timestamps=false;
    public function tipopaquete(){
        return $this->belongsTo('App\tipopaquete');
     } 
}
