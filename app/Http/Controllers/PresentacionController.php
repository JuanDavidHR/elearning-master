<?php

namespace App\Http\Controllers;

use App\Presentacion;
use Illuminate\Http\Request;
use DB;;

class PresentacionController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $presentaciones = Presentacion::select('id', 'codigo', 'nombre')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $presentaciones->total(),
                'current_page'      => $presentaciones->currentPage(),
                'per_page'          => $presentaciones->perPage(),
                'last_page'         => $presentaciones->lastPage(),
                'from'              => $presentaciones->firstItem(),
                'to'                => $presentaciones->lastItem(),
            ], 'presentaciones'     => $presentaciones
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $presentacion = new Presentacion();
            $presentacion->codigo = $request->codigo;
            $presentacion->nombre = $request->nombre;            
            $presentacion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $presentacion = Presentacion::findOrFail($request->id);
            $presentacion->codigo = $request->codigo;
            $presentacion->nombre = $request->nombre;            
            $presentacion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function selectPresentacion(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $presentacion =Presentacion::where('vigencia','=',1)
        ->select('id','nombre')->orderBy('nombre','asc')->get();

        return ['presentacion'=>$presentacion];
    }
}
