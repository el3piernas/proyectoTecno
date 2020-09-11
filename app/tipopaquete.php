<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipopaquete extends Model
{
    protected $table="tipopaquete";
    protected $fillable=[
        'nombre',
        'descripcion'
    ];
    public $timestamps=false;
    public function paquete(){
        return $this->hasMany('App\paquete');
   }
}
