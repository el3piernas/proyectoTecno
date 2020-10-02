<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\empleado;
class ctrlEmpleado extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $empleado = empleado::orderBy('id', 'desc')-> paginate(5);
        }
        else{
            $empleado = empleado::where($criterio, 'like', '%'.$buscar . '%')->orderBy('id', 'desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'          =>$empleado->total(),
                'current_page' => $empleado->currentPage(),
                'per_page'     => $empleado->perPage(),
                'last_page'    => $empleado->lastPage(),
                'from'         => $empleado->firstItem(),
                'to'           => $empleado->lastItem(),
            ],
            'empleado' => $empleado
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
       $empleado= new empleado;
       $empleado->nombre=$request->nombre;
       $empleado->apellido=$request->apellido;
       $empleado->ci=$request->ci;
       $empleado->telefono=$request->telefono;
       $empleado->usuario=$request->usuario;
       $empleado->password=$request->password;
       $empleado->save();
    }

    public function actualizar(Request $request)
    {
       $empleado= empleado::findOrFail($request->id);
       $empleado->nombre=$request->nombre;
       $empleado->apellido=$request->apellido;
       $empleado->ci=$request->ci;
       $empleado->telefono=$request->telefono;
       $empleado->usuario=$request->usuario;
       $empleado->password=$request->password;
       $empleado->save();
    }

    public function eliminar($id)
    {
        $empleado=empleado::find($id);
        $empleado->delete();
    }
    public function selectEmpleado(Request $request){
        if (!$request->ajax()) return redirect('/');
        $empleado = empleado::where('id','>=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['empleado' => $empleado];
    }

    public function todos(){
        //if (!$request->ajax()) return redirect('/');
        $empleado = empleado::select("id","nombre")->get();
        return ['data' => $empleado];
    }
}
