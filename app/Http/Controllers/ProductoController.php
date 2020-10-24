<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Producto;
use App\lote;
use App\Kardex;
use Carbon\Carbon;
use App\Http\Requests\ArticuloStoreRequest;
use App\Http\Requests\ArticuloUpdateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
class ProductoController extends Controller
{
    public function selectProducto(Request $request){
        //mosa que debo de sumar en las ventas :3
        if (!$request->ajax()) return redirect('/');
            $filtro = $request->filtro;
            $productos = Producto::where('codigoProducto', 'like', '%'.$filtro.'%')
            ->orWhere('nombre', 'like', '%'.$filtro.'%')
            ->select('idProducto', 'nombre', 'codigoProducto', 'precioVenta', 'stock')
            ->orderby('nombre', 'asc')
            ->limit(3)
            ->get();
            return ['productos'=>$productos]; 
    }
    public function obtenerCuadros(Request $request){
        if (!$request->ajax()) return redirect('/');
            $idCategoria = $request->idCategoria;
            $productos = Producto::where('idCategoria', '=', $idCategoria)
            ->select('idProducto', 'nombre', 'codigoProducto', 'precioVenta', 'precioCompra', 'stock')
            ->orderby('nombre', 'asc')
            ->get();
            return ['productos'=>$productos]; 
    }
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar ==''){
            $producto = Producto::join('categoria', 'producto.idCategoria', '=', 'categoria.idCategoria')
            ->select('producto.idProducto', 'producto.idCategoria', 'producto.codigoProducto', 'producto.nombre',
             'producto.precioVenta', 'producto.precioCompra', 'producto.stock', 'categoria.nombre as categoriaName',
              'producto.descripcion', 'producto.vigencia', 'producto.precioMayor', 'producto.stockMinimo',
               'producto.usaInventario', 'producto.usaSerie')
            ->orderBy('producto.idProducto', 'desc')->paginate(5);
        }else{
            if($criterio == 'todo'){
                $producto = Producto::join('categoria', 'producto.idCategoria', '=', 'categoria.idCategoria')
                ->select('producto.idProducto', 'producto.idCategoria', 'producto.codigoProducto', 'producto.nombre',
             'producto.precioVenta', 'producto.precioCompra', 'producto.stock', 'categoria.nombre as categoriaName',
              'producto.descripcion', 'producto.vigencia', 'producto.precioMayor', 'producto.stockMinimo',
              'producto.usaInventario', 'producto.usaSerie')
              ->where('producto.nombre', 'like', '%'.$buscar.'%')->orwhere('categoria.nombre', 'like', '%'.$buscar.'%')
                ->orderBy('producto.idProducto', 'desc')->paginate(5);
            }else {
                $producto = Producto::join('categoria', 'producto.idCategoria', '=', 'categoria.idCategoria')
                ->select('producto.idProducto', 'producto.idCategoria', 'producto.codigoProducto', 'producto.nombre',
             'producto.precioVenta', 'producto.precioCompra', 'producto.stock', 'categoria.nombre as categoriaName',
              'producto.descripcion', 'producto.vigencia', 'producto.precioMayor', 'producto.stockMinimo',
               'producto.usaInventario', 'producto.usaSerie')
                ->where('producto.'.$criterio, 'like', '%'.$buscar.'%')->orderBy('producto.idProducto', 'desc')->paginate(5);
            }
        } 
        return [
            'pagination' => [
                'total'             => $producto->total(),
                'current_page'      => $producto->currentPage(),
                'per_page'          => $producto->perPage(),
                'last_page'         => $producto->lastPage(),
                'from'              => $producto->firstItem(),
                'to'                => $producto->lastItem(),
            ], 'producto' => $producto
        ];
    }
    public function store(ArticuloStoreRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $producto = new Producto();
            $producto->idCategoria = $request->idCategoria;
            $producto->codigoProducto = $request->codigoProducto;
            $producto->nombre = $request->nombre;
            $producto->precioVenta = $request->precioVenta;
            $producto->precioCompra = $request->precioCompra;
            $producto->precioMayor = $request->precioMayor;
            $producto->stock = $request->stock;
            $producto->stockMinimo = $request->stockMinimo;
            $producto->usaInventario = $request->usaInventario;
            $producto->tipoVenta = $request->tipoVenta;
            $producto->descripcion = $request->descripcion;
            $producto->usaSerie = $request->usaSerie;
            $producto->save();
            $lote = new lote();
            $date = Carbon::now('America/Lima')->format('y-m-d');
            $lote->idProducto = $producto->idProducto;
            $lote->idProveedor = 1;
            $lote->fechaCompra = $date;
            $lote->comprobante = $request->comprobante;
            $lote->precioCompra = $request->precioCompra;
            $lote->descripcion = $request->desc;
            $lote->cantidad = $request->stock;
            $lote->save();
            $kardex = new Kardex();
            $kardex->idProducto = $producto->idProducto;
            $kardex->idUser = Auth::user()->id;
            $kardex->fecha = $date;
            $kardex->motivo = 'Registro Inicial';
            $kardex->cantidad = $producto->stock;
            $kardex->tipo = 'INGRESO';
            // 'total', 'precioCompra', 'habia', 'hay'
            $kardex->total = $producto->stock * $producto->precioCompra;
            $kardex->precioCompra = $producto->precioCompra;
            $kardex->habia = 0;
            $kardex->hay = $producto->stock;
            $kardex->save();
            DB::commit();   
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function update(ArticuloUpdateRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
            $producto = Producto::findOrFail($request->idProducto);
            $producto->idCategoria = $request->idCategoria;
            $producto->codigoProducto = $request->codigoProducto;
            $producto->nombre = $request->nombre;
            $producto->precioVenta = $request->precioVenta;
            $producto->precioCompra = $request->precioCompra;
            $producto->precioMayor = $request->precioMayor;
            $producto->stockMinimo = $request->stockMinimo;
            $producto->tipoVenta = $request->tipoVenta;
            $producto->descripcion = $request->descripcion;
            $producto->usaSerie = $request->usaSerie;
            $producto->vigencia = $request->vigencia;
        $producto->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->idProducto);//accedemos a cada una de las propiedades
        $producto->vigencia = '0';
        $producto->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->idProducto);//accedemos a cada una de las propiedades
        $producto->vigencia = '1';
        $producto->save();
    }
    public function obtenerDatos(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idArticulo = $request->idArticulo;
        $serie = DB::select("call obtenerCantidadSerie(?)",array($idArticulo));
        return ['informacion' => $serie]; 
    }
    public function mostrar(Request $request){
        if(!$request->ajax()) return redirect('/');
        $producto = Producto::orderBy('nombre')->get();
        return $producto;
    }

}
