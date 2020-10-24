<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\DetalleMedicamento;
class DetalleMedicamentoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $detalle_medicamentos = DetalleMedicamento::join('medicamento','detalla_medicamento.idMedicamento','=','medicamento.id')
        ->join('presentacion','detalla_medicamento.idPresentacion','=','presentacion.id')
        ->join('tipo_medicamento','detalla_medicamento.idTipo','=','tipo_medicamento.id')
        ->join('laboratorio','detalla_medicamento.idLaboratorio','=','laboratorio.id')
        ->join('botica','detalla_medicamento.idBotica','=','botica.id')
        ->select('detalla_medicamento.id', 'detalla_medicamento.codigo', 'medicamento.nombre as nombre_medicamento','presentacion.nombre as nombre_presentacion',
        'tipo_medicamento.nombre as nombre_tipo','laboratorio.nombre as nombre_laboratorio','botica.nombre as nombre_botica','detalla_medicamento.precio','detalla_medicamento.registroSanitario')
        ->orderBy('detalla_medicamento.id', 'asc')
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
            $detalle_medicamento = new DetalleMedicamento();
            $detalle_medicamento->idMedicamento = $request->idMedicamento;
            $detalle_medicamento->idPresentacion = $request->idPresentacion;
            $detalle_medicamento->idTipo = $request->idTipo;
            $detalle_medicamento->idLaboratorio = $request->idLaboratorio;
            $detalle_medicamento->idBotica = $request->idBotica;
            $detalle_medicamento->codigo = $request->codigo;  
            $detalle_medicamento->precio = $request->precio;     
            $detalle_medicamento->registroSanitario = $request->registroSanitario;         
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
            $detalle_medicamento = DetalleMedicamento::findOrFail($request->id);
            $detalle_medicamento->idMedicamento = $request->idMedicamento;
            $detalle_medicamento->idPresentacion = $request->idPresentacion;
            $detalle_medicamento->idTipo = $request->idTipo;
            $detalle_medicamento->idLaboratorio = $request->idLaboratorio;
            $detalle_medicamento->idBotica = $request->idBotica;
            $detalle_medicamento->codigo = $request->codigo;  
            $detalle_medicamento->precio = $request->precio;     
            $detalle_medicamento->registroSanitario = $request->registroSanitario;         
            $detalle_medicamento->save();;
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
