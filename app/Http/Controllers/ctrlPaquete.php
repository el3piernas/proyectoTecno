<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\paquete;

class ctrlPaquete extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect ('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $paquete = paquete::join('tipopaquete','paquete.idTipoPaquete','=', 'tipopaquete.id')
            ->select('paquete.id','paquete.idTipoPaquete','tipopaquete.nombre','paquete.acontecimiento','paquete.precio',)
            ->orderBy('paquete.id','desc')->paginate(3);
        }
        else{$paquete = paquete::join('tipopaquete','paquete.idTipoPaquete','=', 'tipopaquete.id')
            ->select('paquete.id','paquete.idTipoPaquete','tipopaquete.nombre','paquete.acontecimiento','paquete.precio',)
            ->where('paquete.'.$criterio, 'like', '%'. $buscar . '%' ) 
            ->orderBy('paquete.id','desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total'        => $paquete->total(),
                'current_page' => $paquete->currentPage(),
                'per_page'     => $paquete->perPage(),
                'last_page'    => $paquete->lastPage(),
                'from'         => $paquete->firstItem(),
                'to'           => $paquete->lastItem(),
            ],
            'paquete' =>$paquete
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
        if (!$request->ajax()) return redirect('/');
        $paquete = new paquete();
        $paquete->idTipoPaquete = $request->idTipoPaquete;
        $paquete->acontecimiento = $request->acontecimiento;
        $paquete->precio = $request->precio;
        $paquete->save();
    }
    public function actualizar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paquete = paquete::findOrFail($request->id);
        $paquete->idTipoPaquete = $request->idTipoPaquete;
        $paquete->acontecimiento = $request->acontecimiento;
        $paquete->precio = $request->precio;
        $paquete->save();
    }

    public function eliminar($id)
    {
        $paquete=paquete::find($id);
        $paquete->delete();
    }
    
}
