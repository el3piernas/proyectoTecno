<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tipopaquete;

class ctrlTipoPaquete extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $tipopaquete = tipopaquete::orderBy('id', 'desc')->paginate(5);
        }
        else{
            $tipopaquete = tipopaquete::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $tipopaquete->total(),
                'current_page' => $tipopaquete->currentPage(),
                'per_page'     => $tipopaquete->perPage(),
                'last_page'    => $tipopaquete->lastPage(),
                'from'         => $tipopaquete->firstItem(),
                'to'           => $tipopaquete->lastItem(),
            ],
            'tipopaquete' => $tipopaquete
        ];
        
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function selectTipoPaquete(){
        //if (!$request->ajax()) return redirect('/');
        $tipopaquete = tipopaquete::select("id","nombre")->get();
        return ['data' => $tipopaquete];
    }

    public function guardar(Request $request)
    {
        $tipopaquete= new tipopaquete;
        $tipopaquete->nombre=$request->nombre;
        $tipopaquete->descripcion=$request->descripcion;
        $tipopaquete->save();
    }
    
    public function actualizar(Request $request)
    {
        $tipopaquete= tipopaquete::findOrFail($request->id);
        $tipopaquete->nombre=$request->nombre;
        $tipopaquete->descripcion=$request->descripcion;
        $tipopaquete->save();
    }
    public function eliminar($id)
    {
        $tipopaquete=tipopaquete::find($id);
        $tipopaquete->delete();
    }

 }

    
