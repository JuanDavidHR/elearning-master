<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja;
use App\MovimientoCaja;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class CajaController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $caja = Caja::where('descripcion', '=', 'Caja Chica de la Empresa.')->get();
            return [
                'caja' => $caja
            ];
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function viewDetail(Request $request){
        if(!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $movimiento = MovimientoCaja::where('idCaja', '=', $request->idCaja)->where('estado', '=', 'Apertura')->get();
            return [
                'movimiento' => $movimiento
            ];
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function open(Request $request){
        if(!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $caja= Caja::findOrFail($request->idCaja);
            $movimiento = new MovimientoCaja();
            $movimiento->idCaja = $caja->idCaja;
            $movimiento->id = Auth::user()->id;
            $movimiento->fechaApertura = Carbon::now('America/Lima');
            $movimiento->dineroInicial = $request->monto;
            $movimiento->save();
            $caja->estado = 1;
            $caja->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
