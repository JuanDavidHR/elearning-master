<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Ingreso; 
use App\Lote;
use App\Kardex; 
use App\Producto; 
use App\DetalleIngreso; 

class IngresoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $ingreso = Ingreso::join('personas', 'ingresos.idProveedor', '=', 'personas.id')
            ->join('users', 'ingresos.idUsuario', '=', 'users.id')
            ->select('ingresos.idIngreso', 'ingresos.tipoComprobante', 'ingresos.serieComprobante',
            'ingresos.numComprobante', 'ingresos.fecha_compra', 'ingresos.impuesto',
            'ingresos.total', 'ingresos.estado', 'personas.nombre', 'users.usuario')
            ->orderBy('ingresos.idIngreso', 'desc')
            ->paginate(5);
        }
        else{
            $ingreso = Ingreso::join('personas', 'ingresos.idProveedor', '=', 'personas.id')
            ->join('users', 'ingresos.idUsuario', '=', 'users.id')
            ->select('ingresos.idIngreso', 'ingresos.tipoComprobante', 'ingresos.serieComprobante',
            'ingresos.numComprobante', 'ingresos.fecha_compra', 'ingresos.impuesto',
            'ingresos.total', 'ingresos.estado', 'personas.nombre', 'users.usuario')
            ->where('ingresos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ingresos.idIngreso', 'desc')
            ->paginate(5);
        }
        
        return [
            'pagination' => [
                'total'        => $ingreso->total(),
                'current_page' => $ingreso->currentPage(),
                'per_page'     => $ingreso->perPage(),
                'last_page'    => $ingreso->lastPage(),
                'from'         => $ingreso->firstItem(),
                'to'           => $ingreso->lastItem(),
            ],
            'ingresos' => $ingreso
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $date = Carbon::now('America/Lima')->format('y-m-d');
            $ingreso = new Ingreso();
            $ingreso->idProveedor = $request->idProveedor;
            $ingreso->idUsuario = Auth::user()->id;
            $ingreso->tipoComprobante =$request->tipoComprobante;
            $ingreso->serieComprobante = $request->serieComprobante;
            $ingreso->numComprobante = $request->numComprobante;
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = $request->total;
            $ingreso->fecha_compra = $date->toDateString();
            $ingreso->estado = 'Registrado';
            $ingreso->save();
            $detalles = $request->data;
            foreach ($detalles as $ep => $det) {
                //lote
                $lote = new Lote();
                $lote->idProducto = $det['idProducto'];
                $lote->idProveedor = $ingreso->idProveedor;
                $lote->fechaCompra = $date->toDateString();
                $lote->comprobante = $ingreso->tipoComprobante .' '. $ingreso->serieComprobante . '-' .$ingreso->numComprobante;
                $lote->precioCompra = $det['precio'];
                $lote->descripcion = 'Compra';
                $lote->cantidad = $det['cantidad'];
                $lote->utilizaGarantia = false;
                $lote->fechaGarantia = '';
                $lote->vigencia = false;
                $lote->save();
                //detalle
                $detalle = new DetalleIngreso();
                $detalle->idIngreso = $ingreso->idIngreso;
                $detalle->idProducto = $det['idProducto'];
                $detalle->idLote = $
                $detalle->precio = $det['precio'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->save();
                $kardex = new Kardex();
                $kardex->idProducto = $det['idProducto'];
                $kardex->idUser = Auth::user()->id;
                $kardex->fecha = $date->toDateString();
                $kardex->motivo = 'Compra '. $lote->comprobante;
                $kardex->cantidad = $det['cantidad'];
                $kardex->tipo = 'INGRESO';
                $kardex->vigencia = true;
                $kardex->precioCompra = $det['precio'];
                $producto = Producto::findOrFail($det['idProducto']);
                $kardex->habia = $producto->stock;
                $kardex->hay = $kardex->habia + $det['cantidad'];
            }   
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $ingreso = Ingreso::findOrFail($request->idIngreso);//accedemos a cada una de las propiedades
        $ingreso->estado = 'Observación';
        $ingreso->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $ingreso = Ingreso::findOrFail($request->idIngreso);//accedemos a cada una de las propiedades
        $ingreso->estado = 'Observación';
        $ingreso->save();
    }
}
