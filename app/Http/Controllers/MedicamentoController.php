<?php

namespace App\Http\Controllers;

use App\Medicamento;
use App\TipoMedicamento;
use Illuminate\Http\Request;
use DB;

class MedicamentoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $medicamentos = Medicamento::select('medicamento.id', 'medicamento.codigo', 'medicamento.nombre')
        ->orderBy('medicamento.id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $medicamentos->total(),
                'current_page'      => $medicamentos->currentPage(),
                'per_page'          => $medicamentos->perPage(),
                'last_page'         => $medicamentos->lastPage(),
                'from'              => $medicamentos->firstItem(),
                'to'                => $medicamentos->lastItem(),
            ], 'medicamentos' => $medicamentos
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $medicamento = new Medicamento();
            //$medicamento->idTipoMedicamento = $request->idTipoMedicamento;
            $medicamento->codigo = $request->codigo;
            $medicamento->nombre = $request->nombre;            
            $medicamento->save();
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
            $medicamento = Medicamento::findOrFail($request->id);
            //$medicamento->idTipoMedicamento = $request->idTipoMedicamento;
            $medicamento->codigo = $request->codigo;
            $medicamento->nombre = $request->nombre;                      
            $medicamento->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function selectMedicamento(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $medicamento =Medicamento::where('vigencia','=',1)
        ->select('id','nombre')->orderBy('nombre','asc')->get();

        return ['medicamento'=>$medicamento];
    }
}
