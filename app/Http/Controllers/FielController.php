<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FielGarantiaRequest;
use App\Http\Requests\FielUpdateRequest;
use App\Http\Requests\FielStoreRequest;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Fiel;
use Illuminate\Http\Request;

class FielController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $mes = $request->mes;
        $anho = $request->anho;
        if(!$request->ajax()) return redirect('/');
            if($buscar == '' && $mes ==''){
                $fiel = Fiel::select('idFiel', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
                , 'monto_garantia', 'fecha_inicio_garantia', 'fecha_termino_garantia', 'fecha_inicio_contrato', 'fecha_termino_contrato'
                , 'monto_adicional_1', 'monto_adicional_2', 'monto_adicional_3', 'monto_reduccion', 'fecha_termino_ampliacion', 'vigencia')
                ->orderBy('idFiel', 'desc')
                ->paginate(4);
            }else{
                if( $buscar != '' && $mes ==''){
                    $fiel = Fiel::select('idFiel', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
                    , 'monto_garantia', 'fecha_inicio_garantia', 'fecha_termino_garantia', 'fecha_inicio_contrato', 'fecha_termino_contrato'
                    , 'monto_adicional_1', 'monto_adicional_2', 'monto_adicional_3', 'monto_reduccion', 'fecha_termino_ampliacion', 'vigencia')
                    ->where('documento_remision', 'like', '%'.$buscar.'%')
                    ->orwhere('contrato', 'like', '%'.$buscar.'%')
                    ->orderBy('idFiel', 'desc')
                    ->paginate(4);
                }else{
                    if($buscar != '' && $mes !=''){
                        $fiel = Fiel::select('idFiel', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
                    , 'monto_garantia', 'fecha_inicio_garantia', 'fecha_termino_garantia', 'fecha_inicio_contrato', 'fecha_termino_contrato'
                    , 'monto_adicional_1', 'monto_adicional_2', 'monto_adicional_3', 'monto_reduccion', 'fecha_termino_ampliacion', 'vigencia')
                    ->whereMonth('fecha_termino_garantia', $mes)
                    ->whereYear('fecha_termino_garantia', $anho)
                    ->where('documento_remision', 'like', '%'.$buscar.'%')
                    ->orwhere('contrato', 'like', '%'.$buscar.'%')
                    ->whereMonth('fecha_termino_garantia', $mes)
                    ->whereYear('fecha_termino_garantia', $anho)
                    ->orderBy('idFiel', 'desc')
                    ->paginate(4);
                    }else{
                        if($buscar == '' && $mes != ''){
                            $fiel = Fiel::select('idFiel', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
                            , 'monto_garantia', 'fecha_inicio_garantia', 'fecha_termino_garantia', 'fecha_inicio_contrato', 'fecha_termino_contrato'
                            , 'monto_adicional_1', 'monto_adicional_2', 'monto_adicional_3', 'monto_reduccion', 'fecha_termino_ampliacion', 'vigencia')
                            ->whereMonth('fecha_termino_garantia', $mes)
                            ->whereYear('fecha_termino_garantia', $anho)
                            ->orderBy('idFiel', 'desc')
                            ->paginate(4);
                        }
                    }
                }
            }
        return [
            'pagination' => [
                'total'             => $fiel->total(),
                'current_page'      => $fiel->currentPage(),
                'per_page'          => $fiel->perPage(),
                'last_page'         => $fiel->lastPage(),
                'from'              => $fiel->firstItem(),
                'to'                => $fiel->lastItem(),
            ], 'fiel' => $fiel
        ];
    }
    public function store(FielStoreRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $fiel = new Fiel();
            $fiel->documento_remision = $request->documento_remision;
            $fiel->fecha_remision = $request->fecha_remision;
            $fiel->fecha_recepcion = $request->fecha_recepcion;
            $fiel->contrato = $request->contrato;
            $fiel->monto_contrato = $request->monto_contrato;
            $fiel->monto_garantia = $request->monto_garantia;
            $fiel->fecha_inicio_garantia = $request->fecha_inicio_garantia;
            $fiel->fecha_termino_garantia = $request->fecha_termino_garantia;
            $fiel->fecha_inicio_contrato = $request->fecha_inicio_contrato;
            $fiel->fecha_termino_contrato = $request->fecha_termino_contrato;
            $fiel->monto_adicional_1 = $request->monto_adicional_1;
            $fiel->monto_adicional_2 = $request->monto_adicional_2;
            $fiel->monto_adicional_3 = $request->monto_adicional_3;
            $fiel->monto_reduccion = $request->monto_reduccion;
            $fiel->fecha_termino_ampliacion = $request->fecha_termino_ampliacion;
            $fiel->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }  
    public function update(FielUpdateRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $fiel = Fiel::findOrFail($request->idFiel);
            $fiel->documento_remision = $request->documento_remision;
            $fiel->fecha_remision = $request->fecha_remision;
            $fiel->fecha_recepcion = $request->fecha_recepcion;
            $fiel->contrato = $request->contrato;
            $fiel->monto_contrato = $request->monto_contrato;
            $fiel->monto_garantia = $request->monto_garantia;
            $fiel->fecha_inicio_garantia = $request->fecha_inicio_garantia;
            $fiel->fecha_termino_garantia = $request->fecha_termino_garantia;
            $fiel->fecha_inicio_contrato = $request->fecha_inicio_contrato;
            $fiel->fecha_termino_contrato = $request->fecha_termino_contrato;
            $fiel->save();
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
            $fiel = Fiel::select('idFiel', 'documento_remision','fecha_remision' ,'fecha_recepcion', 'contrato', 'monto_contrato'
            , 'monto_garantia', 'fecha_inicio_garantia', 'fecha_termino_garantia', 'fecha_inicio_contrato', 'fecha_termino_contrato'
            , 'monto_adicional_1', 'monto_adicional_2', 'monto_adicional_3', 'monto_reduccion', 'fecha_termino_ampliacion', 'vigencia')
            ->where('idFiel', '=', $id)
            ->take(1)
            ->get();
            $fecha = Fiel::
            select('fecha_inicio_garantia', 'fecha_termino_garantia', 'fecha_remision', 'fecha_recepcion')
            ->where('idFiel', '=', $id)
            ->take(1)
            ->get();
            $fecha_remision = Carbon::parse($fecha[0]->fecha_remision)->format('d-m-Y');
            $fecha_recepcion = Carbon::parse($fecha[0]->fecha_recepcion)->format('d-m-Y');
            $fecha_inicio_garantia = Carbon::parse($fecha[0]->fecha_inicio_garantia)->format('d-m-Y');
            $fecha_termino_garantia = Carbon::parse($fecha[0]->fecha_termino_garantia)->format('d-m-Y');
            $pdf = PDF::loadView('fiel', ['fiel'=>$fiel, 'fecha_inicio_garantia' => $fecha_inicio_garantia, 'fecha_termino_garantia' => $fecha_termino_garantia, 'fecha_recepcion'=>$fecha_recepcion, 'fecha_remision'=>$fecha_remision
            ,'title'=>$title, 'monto_sum'=>$monto_sum]);
            return $pdf->stream('');
        } catch (\Exception $ex) {
            return redirect('/');
        }        
    }
}
