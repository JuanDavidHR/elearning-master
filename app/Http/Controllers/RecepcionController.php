<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recepcion;
use App\detalleRecepcion;
use App\Http\Requests\RecepcionStoreRequest;
use App\Http\Requests\RecepcionUpdateRequest;
use Carbon\Carbon;
use DB;
class RecepcionController extends Controller
{
    public function getCoffe(Request $request){
        if(!$request->ajax()) return redirect('/');
        $detalle =  detalleRecepcion::where('detalle_recepcion.idRecepcion', '=', $request->idRecepcion)->where('detalle_recepcion.estado', '=', NULL)->get();
        $recepcion = Recepcion::where('idRecepcion', '=', $request->idRecepcion)->get();
        return ['detalle'=> $detalle, 'recepcion'=>$recepcion];
    }
    public function indexAdquirido(Request $request){
        if(!$request->ajax()) return redirect('/');
        $recepcion = Recepcion::join('entidad', 'entidad.id', '=', 'recepcion.id')
        ->join('proveedores', 'proveedores.id', '=', 'entidad.id')
        ->select('idRecepcion', 'entidad.nombre', 'proveedores.id' , 'recepcion.nombre as guia' ,'cantidad', 'total', 'estado', 'recepcion.vigencia', 'sacosDevolucion', 'entidad.num_documento', 'entidad.nombre as nombrePersona', 'proveedores.zona')
        ->orderBy('idRecepcion', 'desc')
        ->where('recepcion.nombre', 'like', '%'. $request->buscar.'%')
        ->where('estado', '=', 'Adquirido')
        ->where('recepcion.vigencia', '=', 1)
        ->paginate(6); 
        return [
            'pagination' => [
                'total'        => $recepcion->total(),
                'current_page' => $recepcion->currentPage(),
                'per_page'     => $recepcion->perPage(),
                'last_page'    => $recepcion->lastPage(),
                'from'         => $recepcion->firstItem(),
                'to'           => $recepcion->lastItem(),
            ],
            'recepcion' => $recepcion
        ];
    }
    public function indexPago(Request $request){
        if(!$request->ajax()) return redirect('/');
        $recepcion = Recepcion::join('entidad', 'entidad.id', '=', 'recepcion.id')
        ->join('proveedores', 'proveedores.id', '=', 'entidad.id')
        ->select('idRecepcion', 'entidad.nombre', 'proveedores.id' , 'recepcion.nombre as guia' ,'cantidad', 'total', 'estado', 'recepcion.vigencia', 'sacosDevolucion', 'entidad.num_documento', 'entidad.nombre as nombrePersona', 'proveedores.zona')
        ->orderBy('idRecepcion', 'desc')
        ->where('recepcion.nombre', 'like', '%'. $request->buscar.'%')
        ->where('estado', '=', 'Compra')
        ->where('recepcion.vigencia', '=', 1)
        ->paginate(6); 
        return [
            'pagination' => [
                'total'        => $recepcion->total(),
                'current_page' => $recepcion->currentPage(),
                'per_page'     => $recepcion->perPage(),
                'last_page'    => $recepcion->lastPage(),
                'from'         => $recepcion->firstItem(),
                'to'           => $recepcion->lastItem(),
            ],
            'recepcion' => $recepcion
        ];
    }
    public function index(Request $request){

        if(!$request->ajax()) return redirect('/');
        $recepcion = Recepcion::leftJoin('entidad', 'entidad.id', '=', 'recepcion.id')
        ->leftJoin('proveedores', 'proveedores.id', '=', 'entidad.id')
        ->select('idRecepcion', 'recepcion.nombre', 'cantidad', 'total', 'estado', 'recepcion.vigencia', 'entidad.id', 'sacosDevolucion', 'entidad.num_documento', 'entidad.nombre as nombrePersona', 'proveedores.zona')
        ->orderBy('idRecepcion', 'asc')
        ->where('recepcion.nombre', 'like', '%'. $request->buscar.'%')
        ->where('estado', '=', 'Revision')
        ->where('recepcion.vigencia', '=', 1)
        ->paginate(6);
        return [
            'pagination' => [
                'total'        => $recepcion->total(),
                'current_page' => $recepcion->currentPage(),
                'per_page'     => $recepcion->perPage(),
                'last_page'    => $recepcion->lastPage(),
                'from'         => $recepcion->firstItem(),
                'to'           => $recepcion->lastItem(),
            ],
            'recepcion' => $recepcion
        ];
    }
    public function store(RecepcionStoreRequest $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $recepcion = new Recepcion();
            $recepcion->nombre = $request->nombre;
            $recepcion->cantidad = 0;
            $recepcion->total = 0.00;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function storeCashapa(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = new detalleRecepcion();
            $description->idRecepcion = $request->idRecepcion;
            $description->nombre = 'Cashapa';
            $description->tipo = 'Café Cashapa';
            $description->modal = '#cashapa';
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function storeCacao(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = new detalleRecepcion();
            $description->idRecepcion = $request->idRecepcion;
            $description->nombre = 'Cacao';
            $description->tipo = 'Cacao';
            $description->modal = '#cacao';
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function storeCoco(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = new detalleRecepcion();
            $description->idRecepcion = $request->idRecepcion;
            $description->nombre = 'Coco';
            $description->tipo = 'Café Coco';
            $description->modal = '#coco';
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function storeCorriente(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = new detalleRecepcion();
            $description->idRecepcion = $request->idRecepcion;
            $description->nombre = 'Corriente';
            $description->tipo = 'Café Corriente';
            $description->modal = '#corriente';
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function storeCoffe(Request $request){
        if(!$request->ajax()) return redirect('/');
        $denominacion = $request->denominacion;
        DB::beginTransaction();
        try {
            $description = new detalleRecepcion();
            $description->idRecepcion = $request->idRecepcion;
            $description->nombre = 'Café';
            $description->tipo = $denominacion;
            $description->modal = '#cantidad';
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->c = $request->c;
            $description->r = $request->r;
            $description->h = $request->h;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function updateGuia(RecepcionUpdateRequest $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $recepcion->nombre = $request->nombre;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function updateCashapa(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = detalleRecepcion::findOrFail($request->idDetalle);
            $description->nombre = 'Cashapa';
            $description->tipo = 'Café Cashapa';
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function updateCacao(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = detalleRecepcion::findOrFail($request->idDetalle);
            $description->nombre = 'Cacao';
            $description->tipo = 'Cacao';
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function updateCoco(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = detalleRecepcion::findOrFail($request->idDetalle);
            $description->nombre = 'Coco';
            $description->tipo = 'Café Coco';
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function updateCorriente(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = detalleRecepcion::findOrFail($request->idDetalle);
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function updateCoffe(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = detalleRecepcion::findOrFail($request->idDetalle);
            $description->saco = $request->saco;
            $description->kilo = $request->kilo;
            $description->tara = $request->tara;
            $description->kiloNeto = $request->kiloNeto;
            $description->QQ = $request->QQ;
            $description->c = $request->c;
            $description->r = $request->r;
            $description->h = $request->h;
            $description->precioQQ = $request->precioQQ;
            $description->total = $request->total;
            $description->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function deleteCoffe(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $description = detalleRecepcion::findOrFail($request->idDetalle);
            $description->delete();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $cant =  Recepcion::join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->count();
            $sum =  Recepcion::select('detalle_recepcion.total')->join('detalle_recepcion', 'detalle_recepcion.idRecepcion', '=', 'recepcion.idRecepcion')->where('recepcion.idRecepcion', '=', $request->idRecepcion)->sum('detalle_recepcion.total');
            $recepcion->cantidad = $cant;
            $recepcion->total = $sum;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function stateCoffe(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $recepcion->estado = 'Compra';
            $recepcion->id= $request->id;
            $recepcion->sacosDevolucion = $request->numSacos;
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function reviewCoffe(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $recepcion->estado = 'Revision';
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
