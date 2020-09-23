<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\item;

class ctrlItem extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
     
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $item = item::join('tipoitem','item.idTipoItem','=', 'tipoitem.id')
            ->select('item.id','item.idItem','tipoitem.descripcion','item.foto','item.nombre','item.descripcion','item.precio','item.stock')
            ->orderBy('item.id','desc')->paginate(3);
        }
        else{$item = item::join('tipoitem','item.idItem','=', 'tipoitem.id')
            ->select('item.id','item.idItem','tipoitem.descripcion','item.foto','item.nombre','item.descripcion','item.precio','item.stock')
            ->where('item.'.$criterio, 'like', '%'. $buscar . '%' ) 
            ->orderBy('item.id','desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total'        => $item->total(),
                'current_page' => $item->currentPage(),
                'per_page'     => $item->perPage(),
                'last_page'    => $item->lastPage(),
                'from'         => $item->firstItem(),
                'to'           => $item->lastItem(),
            ],
            'item' =>$item
        ];
    }

    public function todos(){
        //if (!$request->ajax()) return redirect('/');
        $lista = item::select("id","nombre")->get();
        return ['data' => $lista];
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
        $item = new item();
        $item->idTipoItem = $request->idTipoItem;
        $item->foto = $request->foto;
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        $item->precio = $request->precio;
        $item->stock = $request->stock;
        $item->save();
    }

    public function actualizar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $item = item::findOrFail($request->id);
        $item->idTipoItem = $request->idTipoItem;
        $item->foto = $request->foto;
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        $item->precio = $request->precio;
        $item->stock = $request->stock;
        $item->save();
    }
    public function eliminar($id)
    {
        $item=item::find($id);
        $item->delete();
     }
}
