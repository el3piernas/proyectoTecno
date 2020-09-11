<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\bitacora;

class ctrlBitacora extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $bitacora = bitacora::join('empleado','bitacora.idEmpleado','=','empleado.id')
            ->select('bitacora.id','bitacora.idEmpleado','bitacora.fecha','bitacora.hora','bitacora.tabla','bitacora.codigoTabla','bitacora.transaccion'
            ,'empleado.nombre')
            ->orderBy('bitacora.id', 'desc')->paginate(3);
        }
        else{
            $bitacora = bitacora::join('empleado','bitacora.idEmpleado','=','empleado.id')
            ->select('bitacora.id','bitacora.idEmpleado','bitacora.fecha','bitacora.hora','bitacora.tabla','bitacora.codigoTabla','bitacora.transaccion'
            ,'empleado.nombre')
            ->where('bitacora.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('bitacora.id', 'desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total'        => $bitacora->total(),
                'current_page' => $bitacora->currentPage(),
                'per_page'     => $bitacora->perPage(),
                'last_page'    => $bitacora->lastPage(),
                'from'         => $bitacora->firstItem(),
                'to'           => $bitacora->lastItem(),
            ],
            'bitacora' => $bitacora
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
        $bitacora = new bitacora();
        $bitacora->idEmpleado = $request->idEmpleado;
        $bitacora->fecha = $request->fecha;
        $bitacora->hora = $request->hora;
        $bitacora->tabla = $request->tabla;
        $bitacora->codigoTabla = $request->codigoTabla;
        $bitacora->transaccion = $request->transaccion;
        $bitacora->save();
    }

 
    public function actualizar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $bitacora = bitacora::findOrFail($request->id);
        $bitacora->idEmpleado = $request->idEmpleado;
        $bitacora->fecha = $request->fecha;
        $bitacora->hora = $request->hora;
        $bitacora->tabla = $request->tabla;
        $bitacora->codigoTabla = $request->codigoTabla;
        $bitacora->transaccion = $request->transaccion;
        $bitacora->save();
    }

    public function eliminar($id)
    {
        $bitacora=bitacora::find($id);
        $bitacora->delete();
    }
    
}
