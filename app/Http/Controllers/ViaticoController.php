<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\ViaticoUpdateRequest;
use App\Http\Requests\ViaticoStoreRequest;
use App\Viatico;
class ViaticoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $mes = $request->mes;
        $anho = $request->anho;
        if(!$request->ajax()) return redirect('/');
            if($buscar == '' && $mes ==''){
                $viatico = Viatico::join('area', 'area.idArea', '=', 'viatico.idArea')
                ->select('area.nombre as nombreArea', 'area.idArea','viatico.idViatico' ,'viatico.fecha_solicitud', 'viatico.fecha_autorizacion', 'viatico.fecha_inicio'
                , 'viatico.fecha_final', 'viatico.fecha_maximo', 'viatico.documento_solicitud', 'viatico.tipo_actividad', 'viatico.documento_autorizacion'
                , 'viatico.nombre_responsable', 'viatico.monto_viatico', 'viatico.vigencia')
                ->orderBy('idViatico', 'desc')
                ->paginate(4);
            }else{
                if( $buscar != '' && $mes ==''){
                    $viatico = Viatico::join('area', 'area.idArea', '=', 'viatico.idArea')
                    ->select('area.nombre as nombreArea', 'area.idArea','viatico.idViatico' ,'viatico.fecha_solicitud', 'viatico.fecha_autorizacion', 'viatico.fecha_inicio'
                    , 'viatico.fecha_final', 'viatico.fecha_maximo', 'viatico.documento_solicitud', 'viatico.tipo_actividad', 'viatico.documento_autorizacion'
                    , 'viatico.nombre_responsable', 'viatico.monto_viatico', 'viatico.vigencia')
                    ->where('viatico.documento_solicitud', 'like', '%'.$buscar.'%')
                    ->orwhere('viatico.documento_autorizacion', 'like', '%'.$buscar.'%')
                    ->orderBy('idViatico', 'desc')
                    ->paginate(4);
                }else{
                    if($buscar != '' && $mes !=''){
                        $viatico = Viatico::join('area', 'area.idArea', '=', 'viatico.idArea')
                    ->select('area.nombre as nombreArea', 'area.idArea','viatico.idViatico' ,'viatico.fecha_solicitud', 'viatico.fecha_autorizacion', 'viatico.fecha_inicio'
                    , 'viatico.fecha_final', 'viatico.fecha_maximo', 'viatico.documento_solicitud', 'viatico.tipo_actividad', 'viatico.documento_autorizacion'
                    , 'viatico.nombre_responsable', 'viatico.monto_viatico', 'viatico.vigencia')
                    ->whereMonth('viatico.fecha_final', $mes)
                    ->whereYear('viatico.fecha_final', $anho)
                    ->where('viatico.documento_solicitud', 'like', '%'.$buscar.'%')
                    ->orwhere('viatico.documento_autorizacion', 'like', '%'.$buscar.'%')
                    ->whereMonth('viatico.fecha_final', $mes)
                    ->whereYear('viatico.fecha_final', $anho)
                    ->orderBy('idViatico', 'desc')
                    ->paginate(4);
                    }else{
                        if($buscar == '' && $mes != ''){
                            $viatico = Viatico::join('area', 'area.idArea', '=', 'viatico.idArea')
                            ->select('area.nombre as nombreArea', 'area.idArea','viatico.idViatico' ,'viatico.fecha_solicitud', 'viatico.fecha_autorizacion', 'viatico.fecha_inicio'
                            , 'viatico.fecha_final', 'viatico.fecha_maximo', 'viatico.documento_solicitud', 'viatico.tipo_actividad', 'viatico.documento_autorizacion'
                            , 'viatico.nombre_responsable', 'viatico.monto_viatico', 'viatico.vigencia')
                            ->whereMonth('viatico.fecha_final', $mes)
                            ->whereYear('viatico.fecha_final', $anho)
                            ->orderBy('idViatico', 'desc')
                            ->paginate(4);
                        }
                    }
                }
            }
        return [
            'pagination' => [
                'total'             => $viatico->total(),
                'current_page'      => $viatico->currentPage(),
                'per_page'          => $viatico->perPage(),
                'last_page'         => $viatico->lastPage(),
                'from'              => $viatico->firstItem(),
                'to'                => $viatico->lastItem(),
            ], 'viatico' => $viatico
        ];
    }
    public function store(ViaticoStoreRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $viatico = new Viatico();
            $viatico->idArea = $request->idArea;
            $viatico->fecha_solicitud = $request->fecha_solicitud;
            $viatico->fecha_autorizacion = $request->fecha_autorizacion;
            $viatico->fecha_inicio = $request->fecha_inicio;
            $viatico->fecha_final = $request->fecha_final;
            $viatico->fecha_maximo = $request->fecha_maximo;
            $viatico->documento_solicitud = $request->documento_solicitud;
            $viatico->tipo_actividad = $request->tipo_actividad;
            $viatico->documento_autorizacion = $request->documento_autorizacion;
            $viatico->nombre_responsable = $request->nombre_responsable;
            $viatico->monto_viatico = $request->monto_viatico;
            $viatico->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
    public function update(ViaticoUpdateRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $viatico = Viatico::findOrFail($request->idViatico);
            $viatico->idArea = $request->idArea;
            $viatico->fecha_solicitud = $request->fecha_solicitud;
            $viatico->fecha_autorizacion = $request->fecha_autorizacion;
            $viatico->fecha_inicio = $request->fecha_inicio;
            $viatico->fecha_final = $request->fecha_final;
            $viatico->fecha_maximo = $request->fecha_maximo;
            $viatico->documento_solicitud = $request->documento_solicitud;
            $viatico->tipo_actividad = $request->tipo_actividad;
            $viatico->documento_autorizacion = $request->documento_autorizacion;
            $viatico->nombre_responsable = $request->nombre_responsable;
            $viatico->monto_viatico = $request->monto_viatico;
            $viatico->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
 
    public function printf(Request $request, $nada, $id, $nada2, $title, $money, $nada3){
        try {
            $viatico = Viatico::join('area', 'area.idArea', '=', 'viatico.idArea')
            ->select('area.nombre as nombreArea','viatico.documento_solicitud', 'viatico.tipo_actividad', 'viatico.documento_autorizacion'
            , 'viatico.nombre_responsable', 'viatico.monto_viatico', 'viatico.vigencia')
            ->where('viatico.idViatico', '=', $id)
            ->orderBy('idViatico', 'desc')
            ->take(1)
            ->get();
            $fecha = Viatico::
            select('fecha_inicio', 'fecha_solicitud', 'fecha_autorizacion', 'fecha_final', 'fecha_maximo')
            ->where('idViatico', '=', $id)
            ->take(1)
            ->get();
            $fecha_inicio = Carbon::parse($fecha[0]->fecha_inicio)->format('d-m-Y');
            $fecha_solicitud = Carbon::parse($fecha[0]->fecha_solicitud)->format('d-m-Y');
            $fecha_autorizacion = Carbon::parse($fecha[0]->fecha_autorizacion)->format('d-m-Y');
            $fecha_final = Carbon::parse($fecha[0]->fecha_final)->format('d-m-Y');
            $fecha_maximo = Carbon::parse($fecha[0]->fecha_maximo)->format('d-m-Y');
            $pdf = PDF::loadView('viatico', ['viatico'=>$viatico, 'fecha_inicio' => $fecha_inicio, 'fecha_solicitud' => $fecha_solicitud, 'fecha_autorizacion' => $fecha_autorizacion,
            'fecha_final'=> $fecha_final,'fecha_maximo'=>$fecha_maximo,'title'=>$title, 'money'=>$money]);
            return $pdf->stream('');
        } catch (\Exception $ex) {
            return redirect('/');
        }        
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $viatico = Viatico::findOrFail($request->idViatico);
        $viatico->vigencia = '0';
        $viatico->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $viatico = Viatico::findOrFail($request->idViatico);
        $viatico->vigencia = '1';
        $viatico->save();
    }
    public function buscar(Request $request){
        if(!$request->ajax()) return redirect('/');
        $wordlist = Viatico::where('nombre_responsable', 'like', $request->nombre)->where('vigencia', '=', '1')->get();
        $wordCount = $wordlist->count();
        return ['cantidad'=>$wordCount];
    }
}
