<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notaservicio;
use App\detallenotapaquete;
use DB;

class ctrlNotaServicio extends Controller
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
            $notaserv = notaservicio::join('cliente','notaservicio.idCliente','=', 'cliente.id')
                                    ->join('empleado','notaservicio.idEmpleado','=','empleado.id')
                                    ->join('salon','notaservicio.idSalon','=','salon.id')
            ->select('notaservicio.id','notaservicio.fecha','notaservicio.fechaInicio','notaservicio.fechaFin','notaservicio.montoTotal','cliente.nombre as nombrecli','empleado.nombre as nombreemp','salon.nombre as nombresalon')
            ->orderBy('notaservicio.id','desc')->paginate(20);
        }
        else{$notaserv = notaservicio::join('cliente','notaservicio.idCliente','=', 'cliente.id')
                                     ->join('empleado','notaservicio.idEmpleado','=','empleado.id')
                                     ->join('salon','notaservicio.idSalon','=','salon.id')
            ->select('notaservicio.id','notaservicio.fecha','notaservicio.fechaInicio','notaservicio.fechaFin','notaservicio.montoTotal','cliente.nombre as nombrecli','empleado.nombre as nombreemp','salon.nombre as nombresalon')
            ->where('cliente.'.$criterio, 'like', '%'. $buscar . '%' ) 
            ->orderBy('notaservicio.id','desc')->paginate(20);
        }
        return [
            'pagination' => [
                'total'        => $notaserv->total(),
                'current_page' => $notaserv->currentPage(),
                'per_page'     => $notaserv->perPage(),
                'last_page'    => $notaserv->lastPage(),
                'from'         => $notaserv->firstItem(),
                'to'           => $notaserv->lastItem(),
            ],
            'notaserv' =>$notaserv
        ];
    }

   public function getBy($id){
       $tabla=notaservicio::findOrFail($id);

       $tabla['detalle']=detallenotapaquete::join('paqueteitem as detItem',
       'detallenotapaquetes.idPaqueteitem','detItem.id')
       ->join('item','detItem.idItem','item.id')
        ->select('detallenotapaquetes.id','detallenotapaquetes.idPaqueteitem',
        'detallenotapaquetes.cantidad'
        ,'detallenotapaquetes.subTotal'
        ,'item.nombre'
        ,DB::raw('detallenotapaquetes.subTotal/detallenotapaquetes.cantidad as precio'))
        ->where('detallenotapaquetes.idNotaservicio',$id)
        ->get();

        return $tabla;
   }

   public function todos(){
    //if (!$request->ajax()) return redirect('/');
    $lista = paquete::select('id','acontecimiento')
    ->get();
    return $lista;
    }
   public function getByDetalle($id){
    
    $tabla=paqueteitem::join('item','paqueteitem.idItem','item.id')
     ->select('paqueteitem.id','paqueteitem.idItem','item.nombre',
     'paqueteitem.cantidad','paqueteitem.precio'
     ,DB::raw('paqueteitem.cantidad*paqueteitem.precio as subTotal'))
     ->where('paqueteitem.idPaquete','=',$id)
     ->get();

     return $tabla;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try{     
        $tabla = new notaservicio();
        $tabla->idCliente = $request->idCliente;
        $tabla->idEmpleado = $request->idEmpleado;
        $tabla->idSalon = $request->idSalon;
        $tabla->fecha = $request->fecha;
        $tabla->fechaInicio = $request->fechaInicio;
        $tabla->fechaFin = $request->fechaFin;
        $tabla->montoTotal = $request->montoTotal;
        $tabla->estado = $request->estado;
        $tabla->save();
        $detalles = $request->detalle;
        foreach($detalles as $det)
        {
            $detalle = new detallenotapaquete();
            $detalle->idNotaservicio=$tabla->id;
            $detalle->idPaqueteitem=$det['id'];
            $detalle->cantidad=$det['cantidad'];
            $detalle->subTotal=$det['subTotal'];
            $detalle->save();
        }
        DB::commit();
        }
        catch(Exception $ex)
        {
            DB::rollBack();
        }
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
