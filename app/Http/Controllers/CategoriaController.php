<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategoriaStoreRequest;
use App\Http\Requests\CategoriaUpdateRequest;
use Illuminate\Http\Request;
use App\Categoria;
class CategoriaController extends Controller
{
    public function selectCategoria(Request $request){ 
        if(!$request->ajax()) return redirect('/');
            $categoria = Categoria::where('vigencia', '=', '1')->
            select('id', 'nombreCategoria')->
            orderBy('nombreCategoria', 'asc')->get();
            return ['categoria' => $categoria];
    }
    public function buscarCategoria(Request $request){
        //mosa que debo de sumar en las ventas :3
        if (!$request->ajax()) return redirect('/');
            $filtro = $request->filtro;
            $categoria = Categoria::where('nombreCategoria', 'like', '%'.$filtro.'%')
            ->where('vigencia', '=', '1')
            ->select('id', 'nombre')
            ->orderby('nombreCategoria', 'asc')
            ->limit(3)
            ->get();
            return ['categoria'=>$categoria]; 
    }

    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $categorias = Categoria::select('id', 'nombreCategoria', 'descripcion')
        ->orderBy('id', 'asc')
        ->paginate(10);
        return [
            'pagination' => [
                'total'             => $categorias->total(),
                'current_page'      => $categorias->currentPage(),
                'per_page'          => $categorias->perPage(),
                'last_page'         => $categorias->lastPage(),
                'from'              => $categorias->firstItem(),
                'to'                => $categorias->lastItem(),
            ], 'categorias' => $categorias
        ];
    }

    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $categoria = new Categoria();
            $categoria->nombreCategoria = $request->nombreCategoria;
            $categoria->descripcion = $request->descripcion;            
            $categoria->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        DB::beginTransaction();
        try {
            $categoria = Categoria::findOrFail($request->id);
            $categoria->nombreCategoria = $request->nombreCategoria;
            $categoria->descripcion = $request->descripcion;            
            $categoria->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
