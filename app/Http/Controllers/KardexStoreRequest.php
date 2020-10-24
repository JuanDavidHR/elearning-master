<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kardex;
class KardexStoreRequest extends Controller
{
    /**
     * Display a listing of the resource.
     *
            * @return \Illuminate\Http\Response
     */
    // public function selectCategoria(Request $request){ 
    //     if(!$request->ajax()) return redirect('/');
    //         $categorias = Categoria::where('condicion', '=', '1')->
    //         select('idCategoria', 'nombreCategoria')->
    //         orderBy('nombreCategoria', 'asc')->get();
    //         return ['categorias' => $categorias];
    // }
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar ==''){
            $kardex = Kardex::join('categorias', 'articulos.idCategoria', '=', 'categorias.idCategoria')
            ->select('articulos.idArticulo', 'articulos.idCategoria', 'articulos.codigoArticulo', 'articulos.nombreArticulo', 'articulos.precioVenta', 'articulos.precioCompra', 'articulos.stock', 'categorias.nombreCategoria', 'articulos.descripcionArticulo', 'articulos.condicion', 'articulos.precioMayoreo', 'articulos.stockMinimo')
            ->orderBy('articulos.idArticulo', 'desc')->paginate(5);
        }else{
            if($criterio == 'todo'){
                $articulos = Articulo::join('categorias', 'articulos.idCategoria', '=', 'categorias.idCategoria')
                ->select('articulos.idArticulo', 'articulos.idCategoria', 'articulos.codigoArticulo', 'articulos.nombreArticulo', 'articulos.precioVenta', 'articulos.precioCompra', 'articulos.stock', 'categorias.nombreCategoria', 'articulos.descripcionArticulo', 'articulos.condicion', 'articulos.precioMayoreo', 'articulos.stockMinimo')
                ->where('articulos.nombreArticulo', 'like', '%'.$buscar.'%')->orwhere('categorias.nombreCategoria', 'like', '%'.$buscar.'%')
                ->orderBy('articulos.idArticulo', 'desc')->paginate(5);
            }else {
                $articulos = Articulo::join('categorias', 'articulos.idCategoria', '=', 'categorias.idCategoria')
                ->select('articulos.idArticulo', 'articulos.idCategoria', 'articulos.codigoArticulo', 'articulos.nombreArticulo', 'articulos.precioVenta', 'articulos.precioCompra', 'articulos.stock', 'categorias.nombreCategoria', 'articulos.descripcionArticulo', 'articulos.condicion', 'articulos.precioMayoreo', 'articulos.stockMinimo')
                ->where('articulos.'.$criterio, 'like', '%'.$buscar.'%')->orderBy('articulos.idArticulo', 'desc')->paginate(5);
            }
        } 
        //$categoria = Categoria::paginate(5);
        return [
            'pagination' => [
                'total'             => $articulos->total(),
                'current_page'      => $articulos->currentPage(),
                'per_page'          => $articulos->perPage(),
                'last_page'         => $articulos->lastPage(),
                'from'              => $articulos->firstItem(),
                'to'                => $articulos->lastItem(),
            ], 'articulos' => $articulos
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaStoreRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        $categoria = new Categoria();//accedemos a cada una de las propiedades
        $categoria->nombreCategoria = $request->nombreCategoria;
        $categoria->descripcionCategoria = $request->descripcionCategoria;
        $categoria->condicion = '1';
        $categoria->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaUpdateRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->idCategoria);//accedemos a cada una de las propiedades
        $categoria->nombreCategoria = $request->nombreCategoria;
        $categoria->descripcionCategoria = $request->descripcionCategoria;
        $categoria->condicion = $request->condicion;
        $categoria->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->idCategoria);//accedemos a cada una de las propiedades
        $categoria->condicion = '0';
        $categoria->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->idCategoria);//accedemos a cada una de las propiedades
        $categoria->condicion = '1';
        $categoria->save();
    }

}
