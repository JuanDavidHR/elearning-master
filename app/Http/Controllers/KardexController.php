<?php

namespace App\Http\Controllers;
use App\Kardex;
use App\Producto;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $kardex = Kardex::join('producto', 'producto.idProducto', '=', 'kardex.idProducto')
        ->join('users', 'users.id', '=', 'kardex.idUser')
        ->select('kardex.fecha', 'users.usuario', 'kardex.motivo', 'kardex.cantidad',
            'kardex.precioCompra', 'kardex.total', 'kardex.habia', 'kardex.hay', 'kardex.tipo')
        ->where('producto.idProducto', '=', $request->idProducto)
        ->orderBy('id_Kardex', 'asc')->paginate(5);
        $datos = Producto::select('producto.nombre', 'producto.stock')
        ->where('producto.idProducto', '=', $request->idProducto)
        ->get();
        return [
            'pagination' => [
                'total'             => $kardex->total(),
                'current_page'      => $kardex->currentPage(),
                'per_page'          => $kardex->perPage(),
                'last_page'         => $kardex->lastPage(),
                'from'              => $kardex->firstItem(),
                'to'                => $kardex->lastItem(),
            ], 'producto' => $kardex, 'datos' => $datos
        ];
    }
    public function reporteKardex(Request $request){
        $kardex = Kardex::join('producto', 'producto.idProducto', '=', 'kardex.idProducto')
        ->join('users', 'users.id', '=', 'kardex.idUser')
        ->select('kardex.fecha', 'users.usuario', 'kardex.motivo', 'kardex.cantidad',
            'kardex.precioCompra', 'kardex.total', 'kardex.habia', 'kardex.hay', 'kardex.tipo')
        ->where('producto.idProducto', '=', 'kardex.idProducto')
        ->orderBy('id_Kardex', 'asc')
        ->get();
        $datos = Producto::select('producto.nombre', 'producto.stock')
        ->where('producto.idProducto', '=', 'kardex.idProducto')
        ->get();
        $pdf = \PDF::loadView('pdf.kardexpdf', ['kardex'=> $kardex])->setPaper('a4', 'landscape');
        return $pdf->download('kardex.pdf');
    }
}
