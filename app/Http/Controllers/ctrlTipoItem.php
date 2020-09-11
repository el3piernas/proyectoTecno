<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tipoitem;
class ctrlTipoItem extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $tipoitem = tipoitem::orderBy('id', 'desc')->paginate(5);
        }
        else{
            $tipoitem = tipoitem::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $tipoitem->total(),
                'current_page' => $tipoitem->currentPage(),
                'per_page'     => $tipoitem->perPage(),
                'last_page'    => $tipoitem->lastPage(),
                'from'         => $tipoitem->firstItem(),
                'to'           => $tipoitem->lastItem(),
            ],
            'tipoitem' => $tipoitem
        ];
    }

 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
       $tipoitem= new tipoitem;
       $tipoitem->descripcion=$request->descripcion;
       $tipoitem->save();
    }
    public function actualizar(Request $request)
    {
        $tipoitem= tipoitem::findOrFail($request->id);
        $tipoitem->descripcion=$request->descripcion;
        $tipoitem->save();
    }
    public function eliminar($id)
    {
        $tipoitem=tipoitem::find($id);
        $tipoitem->delete();
    }


 
}
