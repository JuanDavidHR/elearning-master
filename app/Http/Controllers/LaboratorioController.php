<?php

namespace App\Http\Controllers;

use App\Laboratorio;
use Illuminate\Http\Request;
use DB;

class LaboratorioController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $laboratorios = Laboratorio::select('id', 'codigo', 'nombre')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $laboratorios->total(),
                'current_page'      => $laboratorios->currentPage(),
                'per_page'          => $laboratorios->perPage(),
                'last_page'         => $laboratorios->lastPage(),
                'from'              => $laboratorios->firstItem(),
                'to'                => $laboratorios->lastItem(),
            ], 'laboratorios' => $laboratorios
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $laboratorio = new Laboratorio();
            $laboratorio->codigo = $request->codigo;
            $laboratorio->nombre = $request->nombre;            
            $laboratorio->save();
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
            $laboratorio = Laboratorio::findOrFail($request->id);
            $laboratorio->codigo = $request->codigo;
            $laboratorio->nombre = $request->nombre;            
            $laboratorio->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
