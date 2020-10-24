<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DirectoUpdateRequest;
use App\Http\Requests\DirectoUpdate1Request;
use App\Http\Requests\DirectoUpdate2Request;
use App\Http\Requests\DirectoUpdate3Request;
use App\Http\Requests\FielUpdateRequest;
use App\Http\Requests\DirectoStoreRequest;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Directo;
use Illuminate\Http\Request;

class DirectoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $mes = $request->mes;
        $anho = $request->anho;
        if(!$request->ajax()) return redirect('/');
            if($buscar == '' && $mes ==''){
                $directo = Directo::select('idDirecto', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
                , 'obra', 'fecha_inicio_plazo', 'fecha_termino_plazo', 'monto_adelanto_1', 'monto_adelanto_2'
                , 'monto_adelanto_3', 'monto_adelanto_4', 'fecha_desde_adelanto_1', 'fecha_desde_adelanto_2', 'fecha_desde_adelanto_3', 'fecha_desde_adelanto_4', 'vigencia',
                'fecha_hasta_adelanto_1', 'fecha_hasta_adelanto_2', 'fecha_hasta_adelanto_3', 'fecha_hasta_adelanto_4', 'fecha_reporte')
                ->orderBy('idDirecto', 'desc')
                ->paginate(4);
            }else{
                if( $buscar != '' && $mes ==''){
                    $directo = Directo::select('idDirecto', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
                    , 'obra', 'fecha_inicio_plazo', 'fecha_termino_plazo', 'monto_adelanto_1', 'monto_adelanto_2'
                    , 'monto_adelanto_3', 'monto_adelanto_4', 'fecha_desde_adelanto_1', 'fecha_desde_adelanto_2', 'fecha_desde_adelanto_3', 'fecha_desde_adelanto_4', 'vigencia',
                    'fecha_hasta_adelanto_1', 'fecha_hasta_adelanto_2', 'fecha_hasta_adelanto_3', 'fecha_hasta_adelanto_4', 'fecha_reporte')
                    ->where('documento_remision', 'like', '%'.$buscar.'%')
                    ->orwhere('contrato', 'like', '%'.$buscar.'%')
                    ->orderBy('idDirecto', 'desc')
                    ->paginate(4);
                }else{
                    if($buscar != '' && $mes !=''){
                        $directo = Directo::select('idDirecto', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
                    , 'obra', 'fecha_inicio_plazo', 'fecha_termino_plazo', 'monto_adelanto_1', 'monto_adelanto_2'
                    , 'monto_adelanto_3', 'monto_adelanto_4', 'fecha_desde_adelanto_1', 'fecha_desde_adelanto_2', 'fecha_desde_adelanto_3', 'fecha_desde_adelanto_4', 'vigencia',
                    'fecha_hasta_adelanto_1', 'fecha_hasta_adelanto_2', 'fecha_hasta_adelanto_3', 'fecha_hasta_adelanto_4', 'fecha_reporte')
                    ->whereMonth('fecha_reporte', $mes)
                    ->whereYear('fecha_reporte', $anho)
                    ->where('documento_remision', 'like', '%'.$buscar.'%')
                    ->orwhere('contrato', 'like', '%'.$buscar.'%')
                    ->whereMonth('fecha_reporte', $mes)
                    ->whereYear('fecha_reporte', $anho)
                    ->orderBy('idDirecto', 'desc')
                    ->paginate(4);
                    }else{
                        if($buscar == '' && $mes != ''){
                            $directo = Directo::select('idDirecto', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
                    , 'obra', 'fecha_inicio_plazo', 'fecha_termino_plazo', 'monto_adelanto_1', 'monto_adelanto_2'
                    , 'monto_adelanto_3', 'monto_adelanto_4', 'fecha_desde_adelanto_1', 'fecha_desde_adelanto_2', 'fecha_desde_adelanto_3', 'fecha_desde_adelanto_4', 'vigencia',
                    'fecha_hasta_adelanto_1', 'fecha_hasta_adelanto_2', 'fecha_hasta_adelanto_3', 'fecha_hasta_adelanto_4', 'fecha_reporte')
                            ->whereMonth('fecha_reporte', $mes)
                            ->whereYear('fecha_reporte', $anho)
                            ->orderBy('idDirecto', 'desc')
                            ->paginate(4);
                        }
                    }
                }
            }
        return [
            'pagination' => [
                'total'             => $directo->total(),
                'current_page'      => $directo->currentPage(),
                'per_page'          => $directo->perPage(),
                'last_page'         => $directo->lastPage(),
                'from'              => $directo->firstItem(),
                'to'                => $directo->lastItem(),
            ], 'directo' => $directo
        ];
    }
    public function store(DirectoStoreRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $directo = new Directo();
            $directo->documento_remision = $request->documento_remision;
            $directo->fecha_remision = $request->fecha_remision;
            $directo->fecha_recepcion = $request->fecha_recepcion;
            $directo->contrato = $request->contrato;
            $directo->monto_contrato = $request->monto_contrato;
            $directo->obra = $request->obra;
            $directo->fecha_inicio_plazo = $request->fecha_inicio_plazo;
            $directo->fecha_termino_plazo = $request->fecha_termino_plazo;
            $directo->monto_adelanto_1 = $request->monto_adelanto_1;
            $directo->monto_adelanto_2 = $request->monto_adelanto_2;
            $directo->monto_adelanto_3 = $request->monto_adelanto_3;
            $directo->monto_adelanto_4 = $request->monto_adelanto_4;
            $directo->fecha_desde_adelanto_1 = $request->fecha_desde_adelanto_1;
            $directo->fecha_desde_adelanto_2 = $request->fecha_desde_adelanto_2;
            $directo->fecha_desde_adelanto_3 = $request->fecha_desde_adelanto_3;
            $directo->fecha_desde_adelanto_4 = $request->fecha_desde_adelanto_4;
            $directo->fecha_hasta_adelanto_1 = $request->fecha_hasta_adelanto_1;
            $directo->fecha_hasta_adelanto_2 = $request->fecha_hasta_adelanto_2;
            $directo->fecha_hasta_adelanto_3 = $request->fecha_hasta_adelanto_3;
            $directo->fecha_hasta_adelanto_4 = $request->fecha_hasta_adelanto_4;
            $directo->fecha_reporte = $request->fecha_hasta_adelanto_1;
            $directo->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
    public function update(DirectoUpdateRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $directo = Directo::findOrFail($request->idDirecto);
            $directo->documento_remision = $request->documento_remision;
            $directo->fecha_remision = $request->fecha_remision;
            $directo->fecha_recepcion = $request->fecha_recepcion;
            $directo->contrato = $request->contrato;
            $directo->monto_contrato = $request->monto_contrato;
            $directo->obra = $request->obra;
            $directo->fecha_inicio_plazo = $request->fecha_inicio_plazo;
            $directo->fecha_termino_plazo = $request->fecha_termino_plazo;
            $directo->monto_adelanto_1 = $request->monto_adelanto_1;
            $directo->fecha_desde_adelanto_1 = $request->fecha_desde_adelanto_1;
            $directo->fecha_hasta_adelanto_1 = $request->fecha_hasta_adelanto_1;
            $directo->fecha_reporte = $request->fecha_hasta_adelanto_1;
            $directo->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    } 
    public function update1(DirectoUpdate1Request $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $directo = Directo::findOrFail($request->idDirecto);
            $directo->documento_remision = $request->documento_remision;
            $directo->fecha_remision = $request->fecha_remision;
            $directo->fecha_recepcion = $request->fecha_recepcion;
            $directo->contrato = $request->contrato;
            $directo->monto_contrato = $request->monto_contrato;
            $directo->obra = $request->obra;
            $directo->fecha_inicio_plazo = $request->fecha_inicio_plazo;
            $directo->fecha_termino_plazo = $request->fecha_termino_plazo;
            $directo->monto_adelanto_1 = $request->monto_adelanto_1;
            $directo->monto_adelanto_2 = $request->monto_adelanto_2;
            $directo->fecha_desde_adelanto_1 = $request->fecha_desde_adelanto_1;
            $directo->fecha_desde_adelanto_2 = $request->fecha_desde_adelanto_2;
            $directo->fecha_hasta_adelanto_1 = $request->fecha_hasta_adelanto_1;
            $directo->fecha_hasta_adelanto_2 = $request->fecha_hasta_adelanto_2;
            $directo->fecha_reporte = $request->fecha_hasta_adelanto_2;
            $directo->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
    public function update2(DirectoUpdate2Request $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $directo = Directo::findOrFail($request->idDirecto);
            $directo->documento_remision = $request->documento_remision;
            $directo->fecha_remision = $request->fecha_remision;
            $directo->fecha_recepcion = $request->fecha_recepcion;
            $directo->contrato = $request->contrato;
            $directo->monto_contrato = $request->monto_contrato;
            $directo->obra = $request->obra;
            $directo->fecha_inicio_plazo = $request->fecha_inicio_plazo;
            $directo->fecha_termino_plazo = $request->fecha_termino_plazo;
            $directo->monto_adelanto_1 = $request->monto_adelanto_1;
            $directo->monto_adelanto_2 = $request->monto_adelanto_2;
            $directo->monto_adelanto_3 = $request->monto_adelanto_3;
            $directo->fecha_desde_adelanto_1 = $request->fecha_desde_adelanto_1;
            $directo->fecha_desde_adelanto_2 = $request->fecha_desde_adelanto_2;
            $directo->fecha_desde_adelanto_3 = $request->fecha_desde_adelanto_3;
            $directo->fecha_hasta_adelanto_1 = $request->fecha_hasta_adelanto_1;
            $directo->fecha_hasta_adelanto_2 = $request->fecha_hasta_adelanto_2;
            $directo->fecha_hasta_adelanto_3 = $request->fecha_hasta_adelanto_3;
            $directo->fecha_reporte = $request->fecha_hasta_adelanto_3;
            $directo->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
    public function update3(DirectoUpdate3Request $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $directo = Directo::findOrFail($request->idDirecto);
            $directo->documento_remision = $request->documento_remision;
            $directo->fecha_remision = $request->fecha_remision;
            $directo->fecha_recepcion = $request->fecha_recepcion;
            $directo->contrato = $request->contrato;
            $directo->monto_contrato = $request->monto_contrato;
            $directo->obra = $request->obra;
            $directo->fecha_inicio_plazo = $request->fecha_inicio_plazo;
            $directo->fecha_termino_plazo = $request->fecha_termino_plazo;
            $directo->monto_adelanto_1 = $request->monto_adelanto_1;
            $directo->monto_adelanto_2 = $request->monto_adelanto_2;
            $directo->monto_adelanto_3 = $request->monto_adelanto_3;
            $directo->monto_adelanto_4 = $request->monto_adelanto_4;
            $directo->fecha_desde_adelanto_1 = $request->fecha_desde_adelanto_1;
            $directo->fecha_desde_adelanto_2 = $request->fecha_desde_adelanto_2;
            $directo->fecha_desde_adelanto_3 = $request->fecha_desde_adelanto_3;
            $directo->fecha_desde_adelanto_4 = $request->fecha_desde_adelanto_4;
            $directo->fecha_hasta_adelanto_1 = $request->fecha_hasta_adelanto_1;
            $directo->fecha_hasta_adelanto_2 = $request->fecha_hasta_adelanto_2;
            $directo->fecha_hasta_adelanto_3 = $request->fecha_hasta_adelanto_3;
            $directo->fecha_hasta_adelanto_4 = $request->fecha_hasta_adelanto_4;
            $directo->fecha_reporte = $request->fecha_hasta_adelanto_4;
            $directo->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
    public function updateGarantia(FielGarantiaRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $fiel = Fiel::findOrFail($request->idFiel);
            $fiel->monto_adicional_1 = $request->monto_adicional_1;
            $fiel->monto_adicional_2 = $request->monto_adicional_2;
            $fiel->monto_adicional_3 = $request->monto_adicional_3;
            $fiel->monto_reduccion = $request->monto_reduccion;
            $fiel->fecha_termino_ampliacion = $request->fecha_termino_ampliacion;
            $fiel->fecha_termino_garantia = $request->fecha_termino_ampliacion;
            $fiel->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
    public function printf(Request $request, $nada, $id, $monto_sum, $nada2, $title){
        try {
            $directo = Directo::select('idDirecto', 'documento_remision', 'contrato', 'monto_contrato'
            , 'obra')
            ->where('idDirecto', '=', $id)
            ->take(1)
            ->get();
            $fecha = Directo::
            select('fecha_reporte', 'fecha_desde_adelanto_1', 'fecha_hasta_adelanto_1', 'fecha_remision', 'fecha_recepcion')
            ->where('idDirecto', '=', $id)
            ->take(1)
            ->get();
            $fecha_remision = Carbon::parse($fecha[0]->fecha_remision)->format('d-m-Y');
            $fecha_recepcion = Carbon::parse($fecha[0]->fecha_recepcion)->format('d-m-Y');
            $fecha_inicio_plazo = Carbon::parse($fecha[0]->fecha_desde_adelanto_1)->format('d-m-Y');
            $fecha_termino_plazo = Carbon::parse($fecha[0]->fecha_hasta_adelanto_1)->format('d-m-Y');
            $fecha_reporte = Carbon::parse($fecha[0]->fecha_reporte)->format('d-m-Y');
            $pdf = PDF::loadView('directo', ['directo'=>$directo, 
            'fecha_inicio_plazo' => $fecha_inicio_plazo, 
            'fecha_termino_plazo' => $fecha_termino_plazo, 
            'fecha_recepcion'=>$fecha_recepcion, 
            'fecha_remision'=>$fecha_remision,
            'fecha_reporte'=>$fecha_reporte
            ,'title'=>$title, 'monto_sum'=>$monto_sum]);
            return $pdf->stream('');
        } catch (\Exception $ex) {
            //return redirect('/');
        }        
    }
}
