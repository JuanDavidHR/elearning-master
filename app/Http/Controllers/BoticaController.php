<?php

namespace App\Http\Controllers;

use App\Botica;
use Illuminate\Http\Request;
use DB;

class BoticaController extends Controller
{
    public function index(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $boticas = Botica::select('id', 'codigo', 'nombre','direccion','telefono','longitud','latitud','hapertura','hcierra')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $boticas->total(),
                'current_page'      => $boticas->currentPage(),
                'per_page'          => $boticas->perPage(),
                'last_page'         => $boticas->lastPage(),
                'from'              => $boticas->firstItem(),
                'to'                => $boticas->lastItem(),
            ], 'boticas' => $boticas
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $botica = new Botica();
            $botica->codigo = $request->codigo;
            $botica->nombre = $request->nombre;
            $botica->direccion = $request->direccion;
            $botica->telefono = $request->telefono;
            $botica->longitud = $request->longitud;
            $botica->latitud = $request->latitud;
            $botica->hapertura = $request->hapertura;
            $botica->hcierra = $request->hcierra;              
            $botica->save();
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
            $botica = Botica::findOrFail($request->id);
            $botica->codigo = $request->codigo;
            $botica->nombre = $request->nombre;
            $botica->direccion = $request->direccion;
            $botica->telefono = $request->telefono;
            $botica->longitud = $request->longitud;
            $botica->latitud = $request->latitud;
            $botica->hapertura = $request->hapertura;
            $botica->hcierra = $request->hcierra;       
            $botica->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
