<?php

namespace App\Http\Controllers;
use App\Serie;
use Illuminate\Http\Request;
use App\Http\Requests\SerieStoreRequest;
use DB;

class SerieController extends Controller
{
    public function selectSerie(Request $request){ 
        if(!$request->ajax()) return redirect('/');
            if($request->idLote){
                $serie = serie::join('lote', 'serie.idLote', '=', 'lote.idLote')
            ->select('serie.idSerie', 'serie.descripcion', 'serie.vigencia')
            ->where('serie.idLote', '=', $request->idLote)->orderBy('serie.idSerie', 'desc')->paginate(3);
            }
            return [
                'paginationSerie' => [
                    'total'             => $serie->total(),
                    'current_page'      => $serie->currentPage(),
                    'per_page'          => $serie->perPage(),
                    'last_page'         => $serie->lastPage(),
                    'from'              => $serie->firstItem(),
                    'to'                => $serie->lastItem(),
                ], 'serie' => $serie
            ];
    }
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar ==''){
            $categoria = Categoria::orderBy('idCategoria', 'desc')->paginate(5);
        }else{
            if($criterio == 'todo'){
                $categoria = Categoria::where('nombreCategoria', 'like', '%'.$buscar.'%')->orwhere('descripcionCategoria', 'like', '%'.$buscar.'%')->orderBy('idCategoria', 'desc')->paginate(5);
            }else {
                $categoria = Categoria::where($criterio, 'like', '%'.$buscar.'%')->orderBy('idCategoria', 'desc')->paginate(5);
            }
        } 
        //$categoria = Categoria::paginate(5);
        return [
            'pagination' => [
                'total'             => $categoria->total(),
                'current_page'      => $categoria->currentPage(),
                'per_page'          => $categoria->perPage(),
                'last_page'         => $categoria->lastPage(),
                'from'              => $categoria->firstItem(),
                'to'                => $categoria->lastItem(),
            ], 'categorias' => $categoria
        ];
    }
    public function store(SerieStoreRequest $request)
    {   
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $serie = new Serie();
            $serie->idLote = $request->idLote;
            $serie->serie = $request->serie;
            $serie->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function update(CategoriaUpdateRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->idCategoria);//accedemos a cada una de las propiedades
        $categoria->nombreCategoria = $request->nombreCategoria;
        $categoria->descripcionCategoria = $request->descripcionCategoria;
        $categoria->condicion = $request->condicion;
        $categoria->save();
    }

    public function delete(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $serie = Serie::where('idSerie' ,$request->idSerie)->delete();;
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->idCategoria);//accedemos a cada una de las propiedades
        $categoria->condicion = '1';
        $categoria->save();
    }

}