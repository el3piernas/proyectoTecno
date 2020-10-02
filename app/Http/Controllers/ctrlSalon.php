<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\salon;

class ctrlSalon extends Controller
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
            $salon = salon::orderBy('id', 'desc')->paginate(5);
        }
        else{
            $salon = salon::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $salon->total(),
                'current_page' => $salon->currentPage(),
                'per_page'     => $salon->perPage(),
                'last_page'    => $salon->lastPage(),
                'from'         => $salon->firstItem(),
                'to'           => $salon->lastItem(),
            ],
            'salon' => $salon
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
        $salon= new salon;
        $salon->foto=$request->foto;
        $salon->nombre=$request->nombre;
        $salon->descripcion=$request->descripcion;
        $salon->ubicacion=$request->ubicacion;
        $salon->estado=$request->estado;
        $salon->save();
    }

    public function actualizar(Request $request)
    {
        $salon= salon::findOrFail($request->id);
        $salon->foto=$request->foto;
        $salon->nombre=$request->nombre;
        $salon->descripcion=$request->descripcion;
        $salon->ubicacion=$request->ubicacion;
        $salon->estado=$request->estado;
        $salon->save();
    }
    public function eliminar($id)
    {
        $salon=salon::find($id);
        $salon->delete();
    }
    public function todos(){
        //if (!$request->ajax()) return redirect('/');
        $salon = salon::select("id","nombre")->get();
        return ['data' => $salon];
    }
    
}
