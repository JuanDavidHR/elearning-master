<?php

namespace App\Http\Controllers;
use App\Compra;
use App\Cuenta;
use App\Pago;
use App\Recepcion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $desc = '';
            $stateCompra = '';
            $cuenta = new Cuenta();
            $cuenta->id = $request->id;
            $cuenta->tipo = 'Pagar';
            $cuenta->nombre = 'Compra: ' . $request->guia;
            $cuenta->montoTotal = $request->montoTotal ;
            $cuenta->categoria = 'Compra';
            $cuenta->montoPagado = $request->cantidad * 1;
            $cuenta->saldo = $request->montoTotal * 1 - $request->cantidad * 1;
            if($request->montoTotal > $request->cantidad){
                $cuenta->estado = 'Por Pagar';
                $desc = 'Adelanto de Café';
            }else{
                $cuenta->estado = 'Pagado';
                $desc = 'Pagado Completo';
            }
            $cuenta->save();
            $stateCompra = $cuenta->estado;
            $compra = new Compra();
            $compra->idUser = Auth::user()->id;
            $compra->idRecepcion = $request->idRecepcion;
            $compra->fechaCompra = Carbon::now('America/Lima');
            $compra->total = $request->montoTotal;
            $compra->nombre = $request->nombre;
            $compra->observacion = $request->observacion;
            $compra->estado = $stateCompra;
            $compra->save();
            $pago = new Pago();
            $pago->idCuenta = $cuenta->idCuenta;
            $pago->descripcion = $desc;
            $pago->monto = $request->cantidad;
            $pago->fecha = $compra->fechaCompra;
            $pago->save();
            $recepcion = Recepcion::findOrFail($request->idRecepcion);
            $recepcion->estado = 'Adquirido';
            $recepcion->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
