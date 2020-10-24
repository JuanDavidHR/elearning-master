<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/main', function () {
        $contents = view('contenido/contenido');
        $response = Response::make($contents, 200);
        $response->header('Expires', 'Tue, 1 Jan 1980 00:00:00 GMT');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->header('Pragma', 'no-cache');
        return $response;
        //return view('contenido/contenido');
    })->name('main');
    Route::group(['middleware' => ['Almacenero']], function () {

        Route::get('/kardex', 'KardexController@index');
        Route::get('kardex/reporte', 'KardexController@reporteKardex');

        //Parametros



        //Fin Parametros
        Route::get('/Categoria', 'CategoriaController@index');
        Route::post('/Categoria/registrar', 'CategoriaController@store');
        Route::put('/Categoria/actualizar', 'CategoriaController@update');
        Route::put('/Categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/Categoria/activar', 'CategoriaController@activar');
        Route::get('/Categoria/selectCategoria', 'CategoriaController@selectCategoria');

        Route::get('/Producto', 'ProductoController@index');
        Route::post('/Producto/registrar', 'ProductoController@store');
        Route::put('/Producto/actualizar', 'ProductoController@update');
        Route::put('/Producto/desactivar', 'ProductoController@desactivar');
        Route::put('/Producto/activar', 'ProductoController@activar');
        Route::get('/Producto/obtenerDatos', 'ProductoController@obtenerDatos');

        Route::post('/Serie/registrar', 'SerieController@store');
        Route::get('/Serie/mostrarSerie', 'SerieController@selectSerie');
        Route::post('/Serie/delete', 'SerieController@delete');
        //Lote Inicio
        Route::get('/lote/mostrar', 'loteController@mostrarPagLote');
        Route::post('/lote/modificar', 'loteController@update');
        Route::get('/lote/count', 'loteController@getNumber');

        Route::get('/Proveedor', 'ProveedorController@index');
        Route::post('/Proveedor/registrar', 'ProveedorController@store');
        Route::put('/Proveedor/actualizar', 'ProveedorController@update');
        Route::get('/Proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/Proveedor/getProveedor', 'ProveedorController@getProveedor');

        Route::get('/Curso', 'CursoController@index');
        Route::post('/Curso/store', 'CursoController@store');
        Route::put('/Curso/update', 'CursoController@update');
        Route::get('/Curso/selectCurso', 'CursoController@selectCurso');
        Route::get('/Curso/getCurso', 'CursoController@getCurso');

        //diego
        Route::get('/Escuela', 'EscuelaController@index');
        Route::post('/Escuela/store', 'EscuelaController@store');        
        Route::put('/Escuela/update', 'EscuelaController@update');     
        
        
        Route::get('/Categoria', 'CategoriaController@index');
        Route::post('/Categoria/store', 'CategoriaController@store');
        Route::put('/Categoria/update', 'CategoriaController@update');

        //cuyo
        Route::get('/Laboratorio', 'LaboratorioController@index');
        Route::post('/Laboratorio/store', 'LaboratorioController@store');
        Route::put('/Laboratorio/update', 'LaboratorioController@update');
        Route::get('/Laboratorio/selectLaboratorio', 'LaboratorioController@selectLaboratorio');
 
        Route::get('/TipoMedicamento', 'TipoMedicamentoController@index');
        Route::post('/TipoMedicamento/store', 'TipoMedicamentoController@store');
        Route::put('/TipoMedicamento/update', 'TipoMedicamentoController@update');
        Route::get('/TipoMedicamento/selectTipo', 'TipoMedicamentoController@selectTipo');

        Route::get('/Presentacion', 'PresentacionController@index');
        Route::post('/Presentacion/store', 'PresentacionController@store');
        Route::put('/Presentacion/update', 'PresentacionController@update');
        Route::get('/Presentacion/selectPresentacion', 'PresentacionController@selectPresentacion');

        Route::get('/Medicamento', 'MedicamentoController@index');
        Route::post('/Medicamento/store', 'MedicamentoController@store');
        Route::put('/Medicamento/update', 'MedicamentoController@update');
        Route::get('/Medicamento/selectMedicamento', 'MedicamentoController@selectMedicamento');

        Route::get('/Botica', 'BoticaController@index');
        Route::post('/Botica/store', 'BoticaController@store');
        Route::put('/Botica/update', 'BoticaController@update');
        Route::get('/Botica/selectBotica', 'BoticaController@selectBotica');

        Route::get('/DetallePresentacion', 'DetallePresentacionController@index');
        Route::post('/DetallePresentacion/store', 'DetallePresentacionController@store');
        Route::put('/DetallePresentacion/update', 'DetallePresentacionController@update');

        Route::get('/DetalleMedicamento', 'DetalleMedicamentoController@index');
        Route::post('/DetalleMedicamento/store', 'DetalleMedicamentoController@store');
        Route::put('/DetalleMedicamento/update', 'DetalleMedicamentoController@update');

        Route::get('/Lugar', 'LugarController@index');
        Route::post('/Lugar/store', 'LugarController@store');
        Route::put('/Lugar/update', 'LugarController@update');
        Route::get('/Lugar/selectLugar', 'LugarController@selectLugar');
        Route::get('/Lugar/getLugar', 'LugarController@getLugar');
    });
    Route::group(['middleware' => ['Vendedor']], function () {
        Route::get('/Cliente', 'ClienteController@index');
        Route::post('/Cliente/registrar', 'ClienteController@store');
        Route::put('/Cliente/actualizar', 'ClienteController@update');
        Route::put('/Cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/Cliente/activar', 'ClienteController@activar');
        //el pos xd
    });
    Route::group(['middleware' => ['Administrador']], function () {

        /* Caja */
        Route::get('/Caja', 'CajaController@index');
        Route::get('/Caja/detalle', 'CajaController@viewDetail');
        Route::post('/Caja/apertura', 'CajaController@open');
        /* Fin de Caja */
        /* /Compra */
        Route::post('/Compra/store', 'CompraController@store');
        /* Fin de Compra */
        /* Cuentas */
        Route::get('/Cuentas', 'PagarController@index');
        Route::get('/Cuentas/pago', 'PagarController@getPago');
        /* Fin de Cuentas */
        /* Proveedores */
        Route::get('/Proveedor', 'ProveedorController@index');
        Route::post('/Proveedor/store', 'ProveedorController@store');
        Route::put('/Proveedor/actualizar', 'ProveedorController@update');
        Route::put('/Proveedor/disabled', 'ProveedorController@disabled');
        Route::put('/Proveedor/enabled', 'ProveedorController@enabled');
        Route::get('/Proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        /* Fin PRoveedores */
        /* Distribucion */
        Route::put('/Distribucion/materiaPrima', 'DistribucionController@setMateriaPrima');
        Route::get('/Distribucion', 'DistribucionController@indexMateriaPrima');
        /* Fin de la distribución */
        /* Recepcion de Materia Prima */
        Route::get('/Recepcion', 'RecepcionController@index');
        Route::get('/Recepcion/pago', 'RecepcionController@indexPago');
        Route::get('/Recepcion/adquirido', 'RecepcionController@indexAdquirido');
        Route::post('/Recepcion/store', 'RecepcionController@store');
        Route::post('/Recepcion/store/corriente', 'RecepcionController@storeCorriente');
        Route::post('/Recepcion/store/coffe', 'RecepcionController@storeCoffe');
        Route::post('/Recepcion/store/coco', 'RecepcionController@storeCoco');
        Route::post('/Recepcion/store/cacao', 'RecepcionController@storeCacao');
        Route::post('/Recepcion/store/cashapa', 'RecepcionController@storeCashapa');
        Route::post('/Recepcion/delete/coffe', 'RecepcionController@deleteCoffe');
        Route::get('/Recepcion/store/coffe', 'RecepcionController@getCoffe');
        Route::put('/Recepcion/update/coffe', 'RecepcionController@updateCoffe');
        Route::put('/Recepcion/update/coco', 'RecepcionController@updateCoco');
        Route::put('/Recepcion/update/cacao', 'RecepcionController@updateCacao');
        Route::put('/Recepcion/update/cashapa', 'RecepcionController@updateCashapa');
        Route::put('/Recepcion/update/guia', 'RecepcionController@updateGuia');
        Route::put('/Recepcion/update/corriente', 'RecepcionController@updateCorriente');
        Route::put('/Recepcion/cambioEstado', 'RecepcionController@stateCoffe');
        Route::put('/Recepcion/cambioEstado/revision', 'RecepcionController@reviewCoffe');
        Route::get('/Recepcion/getProveedor', 'ProveedorController@getProveedor');
        /* Fin de la Recepción de materia Prima */
        /* Lote */

        /* Fin de Lote */
        Route::get('/Lotes', 'LoteController@index');
        Route::post('/Lotes/store', 'LoteController@store');
        /* Precio */
        Route::get('/Precios', 'PrecioController@index');
        Route::get('/Precio/buscar', 'PrecioController@buscar');
        Route::post('/Precios/store', 'PrecioController@store');
        Route::put('/Precios/update', 'PrecioController@update');
        /* Fin de Precio */
        /* Parámetro */
        Route::get('/parametro', 'ParametroController@index');
        Route::post('/parametro/store', 'ParametroController@store');
        Route::put('/parametro/update', 'ParametroController@update');
        /* Fin Parámetro */
        /**
         *
         * Quitar lo de Arriba
         *
         */
        Route::get('/Area/selectArea', 'AreaController@selectArea');
        Route::post('/Encargo/registrar', 'EncargoController@store');
        Route::post('/Encargo/actualizar', 'EncargoController@update');
        Route::get('/Encargo', 'EncargoController@index');
        Route::put('/Encargo/activar', 'EncargoController@activar');
        Route::put('/Encargo/desactivar', 'EncargoController@desactivar');
        Route::post('/Encargo/buscarPersona', 'EncargoController@buscar');
        Route::get('/Encargo/printf/{nada}/{id}/{nada2}/{title}/{money}/{nada3}', 'EncargoController@printf');
        //------------------------------------------------------------
        Route::post('/Viatico/registrar', 'ViaticoController@store');
        Route::post('/Viatico/actualizar', 'ViaticoController@update');
        Route::get('/Viatico', 'ViaticoController@index');
        Route::put('/Viatico/activar', 'ViaticoController@activar');
        Route::put('/Viatico/desactivar', 'ViaticoController@desactivar');
        Route::post('/Viatico/buscarPersona', 'ViaticoController@buscar');
        Route::get('/Viatico/printf/{nada}/{id}/{nada2}/{title}/{money}/{nada3}', 'ViaticoController@printf');
        //_------------------------------------------------------------
        Route::post('/Fiel/registrar', 'FielController@store');
        Route::post('/Fiel/actualizar', 'FielController@update');
        Route::post('/Fiel/actualizarGarantia', 'FielController@updateGarantia');
        Route::get('/Fiel', 'FielController@index');
        Route::get('/Fiel/printf/{nada}/{id}/{monto_sum}/{nada2}/{title}', 'FielController@printf');
        //-------------------------------------------------------------
        Route::post('/Directo/registrar', 'DirectoController@store');
        Route::post('/Directo/actualizarGarantia', 'DirectoController@update');
        Route::post('/Directo/actualizarGarantia1', 'DirectoController@update1');
        Route::post('/Directo/actualizarGarantia2', 'DirectoController@update2');
        Route::post('/Directo/actualizarGarantia3', 'DirectoController@update3');
        Route::get('/Directo', 'DirectoController@index');
        Route::get('/Directo/printf/{nada}/{id}/{monto_sum}/{nada2}/{title}', 'DirectoController@printf');
        //------------------
        Route::post('/Materiales/registrar', 'MaterialesController@store');
        Route::post('/Materiales/actualizarGarantia', 'MaterialesController@update');
        Route::post('/Materiales/actualizarGarantia1', 'MaterialesController@update1');
        Route::post('/Materiales/actualizarGarantia2', 'MaterialesController@update2');
        Route::post('/Materiales/actualizarGarantia3', 'MaterialesController@update3');
        Route::get('/Materiales', 'MaterialesController@index');
        Route::get('/Materiales/printf/{nada}/{id}/{monto_sum}/{nada2}/{title}', 'MaterialesController@printf');
        /*
        Final de Rutas Nuevas
        */
        Route::get('/pdf', function(){
            $pdf = PDF ::loadView('welcome');
            return $pdf->stream();
        });
        Route::get('/kardex', 'KardexController@index');
        Route::get('/kardex/reporte', 'KardexController@reporteKardex');

        Route::get('/Cliente', 'ClienteController@index');
        Route::post('/Cliente/registrar', 'ClienteController@store');
        Route::put('/Cliente/actualizar', 'ClienteController@update');
        Route::put('/Cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/Cliente/activar', 'ClienteController@activar');
        Route::get('/Cliente/obtenerDatos', 'ClienteController@selectCliente');

        //el pos xd
        Route::get('/Rol', 'RolController@index');
        Route::get('/Rol/selectRol', 'RolController@selectRol');
        //LOGIN OJO :3
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
        

        Route::get('/Producto', 'ProductoController@index');
        Route::post('/Producto/registrar', 'ProductoController@store');
        Route::put('/Producto/actualizar', 'ProductoController@update');
        Route::put('/Producto/desactivar', 'ProductoController@desactivar');
        Route::put('/Producto/activar', 'ProductoController@activar');
        Route::get('/Producto/mostrar', 'ProductoController@mostrar');
        Route::get('/Producto/obtenerDatos', 'ProductoController@selectProducto');
        Route::get('/Producto/obtenerCuadros', 'ProductoController@obtenerCuadros');
        //Ingresos
        Route::get('/Ingreso', 'IngresoController@index');
        Route::post('/Ingreso/registrar', 'IngresoController@store');
        Route::put('/Ingreso/desactivar', 'IngresoController@desactivar');
        Route::put('/Ingreso/activar', 'IngresoController@activar');
        //Ingresos
        Route::post('/Venta/registrar', 'VentaController@store');


        Route::post('/Serie/registrar', 'SerieController@store');
        Route::get('/Serie/mostrarSerie', 'SerieController@selectSerie');
        Route::post('/Serie/delete', 'SerieController@delete');



        //Cafe Deudas
        Route::get('/Deuda', 'DeudaController@index');
        Route::post('/Deuda/registrar', 'DeudaController@store');
        Route::put('/Deuda/actualizar', 'DeudaController@update');
        Route::get('/Deuda/selectDeuda', 'DeudaController@selectDeuda');


        Route::get('/Grupos', 'GruposController@index');
        Route::post('/Grupos/registrar', 'GruposController@store');
        Route::put('/Grupos/actualizar', 'GruposController@update');
        Route::get('/Grupos/selectGrupos', 'GruposController@selectGrupos');

    });
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});


Route::get('/home', 'HomeController@index')->name('home');
//Usuarios
