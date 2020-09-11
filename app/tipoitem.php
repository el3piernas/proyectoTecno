<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoitem extends Model
{
    protected $table="tipoitem";
    protected $fillable=[
        'descripcion'
    ];
    public $timestamps=false;
    public function item(){
        return $this->hasMany('App\item');
    } 
} 