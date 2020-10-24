<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Venta;
use App\DetalleVenta;
class VentaController extends Controller
{
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $venta = new Venta();
            $date = Carbon::now('America/Lima');
            $venta->idPersona = $request->idPersona;
            $venta->idUsuario = Auth::user()->id;
            $venta->fechaVenta = $date;
            $venta->numeroDoc = $request->numeroDoc;
            $venta->montoTotal = $request->montoTotal;
            $venta->tipoPago = $request->tipoPago;
            $venta->estado = $request->estado;
            $venta->comprobante = $request->comprobante;
            $venta->fechaPago = $date;
            $venta->accion = $request->accion;
            $venta->pagoCon = $request->pagoCon;
            $venta->vuelto = $request->vuelto;
            $venta->porcentaje = $request->porcentaje;
            $venta->idCaja = $request->idCaja;            
            $venta->save();
            $detalleVenta = new DetalleVenta();
            $detalleVenta->idVenta = $venta->idVenta;
            $detalleVenta->idProducto = $request->idProducto;
            $detalleVenta->precioUnitario = $request->precioUnitario;
            $detalleVenta->moneda = $request->moneda;
            $detalleVenta->cantidad = $request->cantidad;
            $detalleVenta->totalProducto = $request->cantidad * $request->precioUnitario;
            $detalleVenta->unidadMedida = $request->unidadMedida;
            $detalleVenta->estado = $request->estado;
            $detalleVenta->nombreProd = $request->nombreProd;
            $detalleVenta->codigoProd = $request->codigoProd;
            $detalleVenta->seVende = $request->seVende;
            $detalleVenta->usaInventario = $request->usaInventario;
            $detalleVenta->costo = $request->costo;
            $detalleVenta->ganancia = (($request->cantidad * $request->precioUnitario) - ($request->cantidad * $request->costo));
            $detalleVenta->save();
            DB::commit(); 
            return $venta->idVenta;  
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
