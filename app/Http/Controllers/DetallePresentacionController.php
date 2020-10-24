<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\DetallePresentacion;
class DetallePresentacionController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $detalle_presentaciones = DetallePresentacion::join('medicamento','detalle_presentacion.idMedicamento','=','medicamento.id')
        ->join('presentacion','detalle_presentacion.idPresentacion','=','presentacion.id')
        ->select('detalle_presentacion.id', 'detalle_presentacion.codigo', 'medicamento.nombre as nombre_medicamento','presentacion.nombre as nombre_presentacion')
        ->orderBy('detalle_presentacion.id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $detalle_presentaciones->total(),
                'current_page'      => $detalle_presentaciones->currentPage(),
                'per_page'          => $detalle_presentaciones->perPage(),
                'last_page'         => $detalle_presentaciones->lastPage(),
                'from'              => $detalle_presentaciones->firstItem(),
                'to'                => $detalle_presentaciones->lastItem(),
            ], 'detalle_presentaciones' => $detalle_presentaciones
        ];
    }
    
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $detalle_presentaciones = new DetallePresentacion();
            $detalle_presentaciones->idMedicamento = $request->idMedicamento;
            $detalle_presentaciones->idPresentacion = $request->idPresentacion;
            $detalle_presentaciones->codigo = $request->codigo;            
            $detalle_presentaciones->save();
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
