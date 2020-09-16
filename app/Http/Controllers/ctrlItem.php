<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\item;

class ctrlItem extends Controller
{
    public function todos(){
        //if (!$request->ajax()) return redirect('/');
        $lista = item::select("id","nombre")->get();
        return ['data' => $lista];
    }
}
