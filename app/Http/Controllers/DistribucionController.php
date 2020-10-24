<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recepcion;
use App\Kardex;
use App\Almacen;
use App\detalleRecepcion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
class DistribucionController extends Controller
{
    public function setMateriaPrima(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $almacen = Almacen::where('nombreAlmacen', '=', $request->nombre)->get();
            $description = detalleRecepcion::findOrFail($request->idDetalleRecepcion);
            $description['estado'] = 'Almacenado';
            $description['idAlmacen'] = $almacen[0]->idAlmacen;
            $description['codigo'] = $almacen[0]->codigoAlmacen . $recepcion['nombre'] . $description['idDetalleRecepcion'];
            $description->save();
            //traer el kardex
            $kardex = new Kardex();
            $kardex->idAlmacen = $almacen[0]->idAlmacen;
            $kardex->idUser = Auth::user()->id;
            $kardex->fecha = Carbon::now('America/Lima')->format('Y-m-d H:i:s');
            $kardex->motivo = 'Compra de Guía' . $recepcion->nombre;
            $kardex->tipo = 'Ingreso';
            $kardex->qTipo = $description['QQ'];
            $kardex->cuTipo = $description['precioQQ'];
            $kardex->ctTipo = $description['total'];
            $kardex->qSaldo = $description['QQ'] + $almacen[0]->pesoNetoQuintal;
            $kardex->cuSaldo = ($almacen[0]->inversion + $description['total']) / ($description['QQ'] + $almacen[0]->pesoNetoQuintal);
            $kardex->ctSaldo = $almacen[0]->inversion + $description['total'];
            $kardex->save();
            $aux = detalleRecepcion::where('detalle_recepcion.estado', '=', 'Almacenado')
            ->where('detalle_recepcion.idAlmacen', '=', $kardex->idAlmacen)
            ->get();
            $hTotal = 0;
            $rTotal = 0;
            $cTotal = 0;
            $total = $aux->count();
            foreach ($aux as $idAux => $rec) {
                $hTotal = $hTotal + $rec['h'];
                $rTotal = $rTotal + $rec['r'];
                $cTotal = $cTotal + $rec['c'];
            }
            $almacenSave = Almacen::findOrFail($kardex->idAlmacen);
            $almacenSave->cAlmacen = $cTotal / $total;
            $almacenSave->hAlmacen = $hTotal / $total;
            $almacenSave->rAlmacen = $rTotal / $total;
            $almacenSave->pesoKg = $almacenSave->pesoKg + $description['kilo'];
            $almacenSave->taraAlmacen = $almacenSave->taraAlmacen + $description['tara'];
            $almacenSave->sacosAlmacen = $almacenSave->sacosAlmacen + $description['saco'];
            $almacenSave->pesoNetoKg = $almacenSave->pesoNetoKg + $description['kiloNeto'];
            $almacenSave->pesoNetoQuintal = $almacenSave->pesoNetoQuintal + $description['QQ'];
            $almacenSave->inversion = $almacenSave->inversion + $description['total'];
            $almacenSave->precioCompra = $kardex->cuSaldo;
            $almacenSave->save();
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->where('detalle_recepcion.estado', '=', NULL)->count();
            if($cant*1 == 0){
                $recepcion->estado = 'Almacenado';
                $recepcion->save();
            }
            DB::commit();
            $aux;
            $cant * 1 == 0 ? $aux = true : $aux = false;
            return ['respuesta'=> $aux];
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function indexMateriaPrima(Request $request){
        if(!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $almacen = Almacen::where('nombreAlmacen', '=', $request->tipo)->get();
            $detalle = detalleRecepcion::select('entidad.nombre as nombre', 'entidad.num_documento as dni', 'detalle_recepcion.saco', 
            'detalle_recepcion.idDetalleRecepcion', 'detalle_recepcion.kilo', 'detalle_recepcion.tara', 'detalle_recepcion.kiloNeto',
            'detalle_recepcion.QQ as quintales', 'detalle_recepcion.c', 'detalle_recepcion.r', 'detalle_recepcion.h', 'detalle_recepcion.precioQQ',
            'detalle_recepcion.total', 'detalle_recepcion.codigo')
            ->join('almacen', 'almacen.idAlmacen', '=', 'detalle_recepcion.idAlmacen')
            ->join('recepcion', 'recepcion.idRecepcion', '=', 'detalle_recepcion.idRecepcion')
            ->join('entidad', 'entidad.id', '=', 'recepcion.id')
            ->where('almacen.idalmacen', '=',$almacen[0]['idAlmacen'])
            ->where('detalle_recepcion.estado', '=', 'Almacenado')
            ->paginate(10);
            return [
                'pagination' => [
                    'total'        => $detalle->total(),
                    'current_page' => $detalle->currentPage(),
                    'per_page'     => $detalle->perPage(),
                    'last_page'    => $detalle->lastPage(),
                    'from'         => $detalle->firstItem(),
                    'to'           => $detalle->lastItem(),
                ],
                'detalle' => $detalle, 'almacen' =>$almacen
            ];
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
