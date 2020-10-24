<?php

namespace App\Http\Controllers;

use App\TipoMedicamento;
use Illuminate\Http\Request;
use DB;

class TipoMedicamentoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $tipo_medicamentos = TipoMedicamento::select('id', 'codigo', 'nombre')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $tipo_medicamentos->total(),
                'current_page'      => $tipo_medicamentos->currentPage(),
                'per_page'          => $tipo_medicamentos->perPage(),
                'last_page'         => $tipo_medicamentos->lastPage(),
                'from'              => $tipo_medicamentos->firstItem(),
                'to'                => $tipo_medicamentos->lastItem(),
            ], 'tipo_medicamentos' => $tipo_medicamentos
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $tipo_medicamento = new TipoMedicamento();
            $tipo_medicamento->codigo = $request->codigo;
            $tipo_medicamento->nombre = $request->nombre;            
            $tipo_medicamento->save();
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
            $tipo_medicamento = TipoMedicamento::findOrFail($request->id);
            $tipo_medicamento->codigo = $request->codigo;
            $tipo_medicamento->nombre = $request->nombre;            
            $tipo_medicamento->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function selectTipo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tipo_medicamentos =TipoMedicamento::where('vigencia','=',1)
        ->select('id','nombre')->orderBy('nombre','asc')->get();

        return ['tipo_medicamentos'=>$tipo_medicamentos];
    }
}
