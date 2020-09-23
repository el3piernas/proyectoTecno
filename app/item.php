<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = "item";
    protected $fillable = [
        'idTipoItem',
        'foto',
        'nombre',
        'descripcion',
        'precio',
        'stock'
       
    ];
    public $timestamps=false;
    public function tipoitem(){
        return $this->belongsTo('App\tipoitem');
    }
}
