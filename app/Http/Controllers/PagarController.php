<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Cuenta;
use App\Pago;

class PagarController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $cuenta = Cuenta::select('cuenta.estado', 'cuenta.idCuenta', 
        'cuenta.montoPagado', 'cuenta.categoria', 'cuenta.montoTotal', 
        'cuenta.saldo', 'cuenta.nombre as descripcion', 'cuenta.tipo', 
        'cuenta.vigencia', 'entidad.nombre')
        ->join('entidad', 'entidad.id', '=', 'cuenta.id')
        ->where('estado', '=', 'Por Pagar')
        ->orderBy('idCuenta', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $cuenta->total(),
                'current_page'      => $cuenta->currentPage(),
                'per_page'          => $cuenta->perPage(),
                'last_page'         => $cuenta->lastPage(),
                'from'              => $cuenta->firstItem(),
                'to'                => $cuenta->lastItem(),
            ], 'cuenta' => $cuenta
        ];
    }
    public function getPago(Request $request){
        if(!$request->ajax()) return redirect('/');
        $pago = Pago::where('pago.idCuenta', '=', $request->idCuenta)
        ->orderBy('idPago', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $pago->total(),
                'current_page'      => $pago->currentPage(),
                'per_page'          => $pago->perPage(),
                'last_page'         => $pago->lastPage(),
                'from'              => $pago->firstItem(),
                'to'                => $pago->lastItem(),
            ], 'pago' => $pago
        ];
    }
}
