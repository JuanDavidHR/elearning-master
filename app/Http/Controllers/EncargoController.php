<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\EncargoUpdateRequest;
use App\Http\Requests\EncargoStoreRequest;
use App\Encargo;
class EncargoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $mes = $request->mes;
        $anho = $request->anho;
        if(!$request->ajax()) return redirect('/');
            if($buscar == '' && $mes ==''){
                $encargo = Encargo::join('area', 'area.idArea', '=', 'encargo.idArea')
                ->select('area.nombre as nombreArea', 'area.idArea','encargo.idEncargo' ,'encargo.fecha_solicitud', 'encargo.fecha_autorizacion', 'encargo.fecha_inicio'
                , 'encargo.fecha_final', 'encargo.fecha_maximo', 'encargo.documento_solicitud', 'encargo.tipo_actividad', 'encargo.documento_autorizacion'
                , 'encargo.nombre_responsable', 'encargo.monto_encargo', 'encargo.vigencia')
                ->orderBy('idEncargo', 'desc')
                ->paginate(4);
            }else{
                if( $buscar != '' && $mes ==''){
                    $encargo = Encargo::join('area', 'area.idArea', '=', 'encargo.idArea')
                    ->select('area.nombre as nombreArea', 'area.idArea','encargo.idEncargo' ,'encargo.fecha_solicitud', 'encargo.fecha_autorizacion', 'encargo.fecha_inicio'
                    , 'encargo.fecha_final', 'encargo.fecha_maximo', 'encargo.documento_solicitud', 'encargo.tipo_actividad', 'encargo.documento_autorizacion'
                    , 'encargo.nombre_responsable', 'encargo.monto_encargo', 'encargo.vigencia')
                    ->where('encargo.documento_solicitud', 'like', '%'.$buscar.'%')
                    ->orwhere('encargo.documento_autorizacion', 'like', '%'.$buscar.'%')
                    ->orderBy('idEncargo', 'desc')
                    ->paginate(4);
                }else{
                    if($buscar != '' && $mes !=''){
                        $encargo = Encargo::join('area', 'area.idArea', '=', 'encargo.idArea')
                    ->select('area.nombre as nombreArea', 'area.idArea','encargo.idEncargo' ,'encargo.fecha_solicitud', 'encargo.fecha_autorizacion', 'encargo.fecha_inicio'
                    , 'encargo.fecha_final', 'encargo.fecha_maximo', 'encargo.documento_solicitud', 'encargo.tipo_actividad', 'encargo.documento_autorizacion'
                    , 'encargo.nombre_responsable', 'encargo.monto_encargo', 'encargo.vigencia')
                    ->whereMonth('encargo.fecha_final', $mes)
                    ->whereYear('encargo.fecha_final', $anho)
                    ->where('encargo.documento_solicitud', 'like', '%'.$buscar.'%')
                    ->orwhere('encargo.documento_autorizacion', 'like', '%'.$buscar.'%')
                    ->whereMonth('encargo.fecha_final', $mes)
                    ->whereYear('encargo.fecha_final', $anho)
                    ->orderBy('idEncargo', 'desc')
                    ->paginate(4);
                    }else{
                        if($buscar == '' && $mes != ''){
                            $encargo = Encargo::join('area', 'area.idArea', '=', 'encargo.idArea')
                            ->select('area.nombre as nombreArea', 'area.idArea','encargo.idEncargo' ,'encargo.fecha_solicitud', 'encargo.fecha_autorizacion', 'encargo.fecha_inicio'
                            , 'encargo.fecha_final', 'encargo.fecha_maximo', 'encargo.documento_solicitud', 'encargo.tipo_actividad', 'encargo.documento_autorizacion'
                            , 'encargo.nombre_responsable', 'encargo.monto_encargo', 'encargo.vigencia')
                            ->whereMonth('encargo.fecha_final', $mes)
                            ->whereYear('encargo.fecha_final', $anho)
                            ->orderBy('idEncargo', 'desc')
                            ->paginate(4);
                        }
                    }
                }
            }
        return [
            'pagination' => [
                'total'             => $encargo->total(),
                'current_page'      => $encargo->currentPage(),
                'per_page'          => $encargo->perPage(),
                'last_page'         => $encargo->lastPage(),
                'from'              => $encargo->firstItem(),
                'to'                => $encargo->lastItem(),
            ], 'encargo' => $encargo
        ];
    }
    public function store(EncargoStoreRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $encargo = new Encargo();
            $encargo->idArea = $request->idArea;
            $encargo->fecha_solicitud = $request->fecha_solicitud;
            $encargo->fecha_autorizacion = $request->fecha_autorizacion;
            $encargo->fecha_inicio = $request->fecha_inicio;
            $encargo->fecha_final = $request->fecha_final;
            $encargo->fecha_maximo = $request->fecha_maximo;
            $encargo->documento_solicitud = $request->documento_solicitud;
            $encargo->tipo_actividad = $request->tipo_actividad;
            $encargo->documento_autorizacion = $request->documento_autorizacion;
            $encargo->nombre_responsable = $request->nombre_responsable;
            $encargo->monto_encargo = $request->monto_encargo;
            $encargo->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
    public function update(EncargoUpdateRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $encargo = Encargo::findOrFail($request->idEncargo);
            $encargo->idArea = $request->idArea;
            $encargo->fecha_solicitud = $request->fecha_solicitud;
            $encargo->fecha_autorizacion = $request->fecha_autorizacion;
            $encargo->fecha_inicio = $request->fecha_inicio;
            $encargo->fecha_final = $request->fecha_final;
            $encargo->fecha_maximo = $request->fecha_maximo;
            $encargo->documento_solicitud = $request->documento_solicitud;
            $encargo->tipo_actividad = $request->tipo_actividad;
            $encargo->documento_autorizacion = $request->documento_autorizacion;
            $encargo->nombre_responsable = $request->nombre_responsable;
            $encargo->monto_encargo = $request->monto_encargo;
            $encargo->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
 
    public function printf(Request $request, $nada, $id, $nada2, $title, $money, $nada3){
        try {
            $encargo = Encargo::join('area', 'area.idArea', '=', 'encargo.idArea')
            ->select('area.nombre as nombreArea','encargo.documento_solicitud', 'encargo.tipo_actividad', 'encargo.documento_autorizacion'
            , 'encargo.nombre_responsable', 'encargo.monto_encargo', 'encargo.vigencia')
            ->where('encargo.idEncargo', '=', $id)
            ->orderBy('idEncargo', 'desc')
            ->take(1)
            ->get();
            $fecha = Encargo::
            select('fecha_inicio', 'fecha_solicitud', 'fecha_autorizacion', 'fecha_final', 'fecha_maximo')
            ->where('idEncargo', '=', $id)
            ->take(1)
            ->get();
            $fecha_inicio = Carbon::parse($fecha[0]->fecha_inicio)->format('d-m-Y');
            $fecha_solicitud = Carbon::parse($fecha[0]->fecha_solicitud)->format('d-m-Y');
            $fecha_autorizacion = Carbon::parse($fecha[0]->fecha_autorizacion)->format('d-m-Y');
            $fecha_final = Carbon::parse($fecha[0]->fecha_final)->format('d-m-Y');
            $fecha_maximo = Carbon::parse($fecha[0]->fecha_maximo)->format('d-m-Y');
            $pdf = PDF::loadView('welcome', ['encargo'=>$encargo, 'fecha_inicio' => $fecha_inicio, 'fecha_solicitud' => $fecha_solicitud, 'fecha_autorizacion' => $fecha_autorizacion,
            'fecha_final'=> $fecha_final,'fecha_maximo'=>$fecha_maximo,'title'=>$title, 'money'=>$money]);
            return $pdf->stream('');
        } catch (\Exception $ex) {
            return redirect('/');
        }        
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $encargo = Encargo::findOrFail($request->idEncargo);
        $encargo->vigencia = '0';
        $encargo->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $encargo = Encargo::findOrFail($request->idEncargo);
        $encargo->vigencia = '1';
        $encargo->save();
    }
    public function buscar(Request $request){
        if(!$request->ajax()) return redirect('/');
        $wordlist = Encargo::where('nombre_responsable', 'like', $request->nombre)->where('vigencia', '=', '1')->get();
        $wordCount = $wordlist->count();
        return ['cantidad'=>$wordCount];
    }
}

