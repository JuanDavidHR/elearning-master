<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\DetalleMedicamento;
class DetalleMedicamentoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $detalle_medicamentos = DetalleMedicamento::join('medicamento','detalle_medicamento.idMedicamento','=','medicamento.id')
        ->join('presentacion','detalle_medicamento.idTipo','=','presentacion.id')
        ->join('tipo_medicamento','detalle_medicamento.idTipo','=','tipo_medicamento.id')
        ->join('laboratorio','detalle_medicamento.idLaboratorio','=','laboratorio.id')
        ->join('botica','detalle_medicamento.idBotica','=','botica.id')
        ->select('detalle_medicamento.id', 'detalle_medicamento.codigo', 'medicamento.nombre as nombre_medicamento','presentacion.nombre as nombre_presentacion',
        'tipo_medicamento.nombre as nombre_tipo','laboratorio.nombre as nombre_laboratorio','botica.nombre as nombre_botica','detalle_medicamento.id')
        ->orderBy('detalle_medicamento.id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $detalle_medicamentos->total(),
                'current_page'      => $detalle_medicamentos->currentPage(),
                'per_page'          => $detalle_medicamentos->perPage(),
                'last_page'         => $detalle_medicamentos->lastPage(),
                'from'              => $detalle_medicamentos->firstItem(),
                'to'                => $detalle_medicamentos->lastItem(),
            ], 'det$detalle_medicamentos' => $detalle_medicamentos
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $detalle_medicamento = new DetallePresentacion();
            $detalle_medicamento->idMedicamento = $request->idMedicamento;
            $detalle_medicamento->idPresentacion = $request->idPresentacion;
            $detalle_medicamento->codigo = $request->codigo;            
            $detalle_medicamento->save();
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
            $detalle_presentacion = DetallePresentacion::findOrFail($request->id);
            $detalle_presentacion->idMedicamento = $request->idMedicamento;
            $detalle_presentacion->idPresentacion = $request->idPresentacion;
            $detalle_presentacion->codigo = $request->codigo;            
            $detalle_presentacion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
