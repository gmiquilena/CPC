<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


Route::get('principal', array('uses' => 'PrincipalController@index'));
Route::get('escritorio', array('uses' => 'EscritorioController@principal'));


//centros de costos
Route::get('ccostos', array('uses' => 'CentrocostoController@principal'));
Route::post('ccostos/CRUD', array('uses' => 'CentrocostoController@CRUD'));
Route::get('ccostos/combobox', array('uses' => 'CentrocostoController@comboBox'));

//conceptos de gastos
Route::any('cgastos/CRUD', array('uses' => 'ConceptoGastoController@CRUD'));
Route::get('cgastos/combobox', array('uses' => 'ConceptoGastoController@comboBox'));


//procesos
Route::get('procesos', array('uses' => 'ProcesoController@principal'));
Route::post('procesos/CRUD', array('uses' => 'ProcesoController@CRUD'));
Route::get('procesos/combobox', array('uses' => 'ProcesoController@comboBox'));
Route::get('procesos/addccostos', array('uses' => 'ProcesoController@addccostos'));
Route::post('procesos/crearpccostos', array('uses' => 'ProcesoController@crearProcesoCcosto'));
Route::post('procesos/eliminarpccostos', array('uses' => 'ProcesoController@eliminarProcesoCcosto'));
Route::get('procesos/treeccostos', array('uses' => 'ProcesoController@treeGridCcostos'));

Route::get('procesos/tree_ccostos_mo', array('uses' => 'ProcesoController@treeGridCcostosMO'));
Route::get('procesos/tree_ccostos_gf', array('uses' => 'ProcesoController@treeGridCcostosGF'));
Route::get('procesos/costo_proceso', array('uses' => 'ProcesoController@costoProceso'));

//maquinas
Route::post('maquinas/CRUD', array('uses' => 'MaquinaController@CRUD'));

//tareas
Route::post('tareas/CRUD', array('uses' => 'TareaController@CRUD'));

//productos
Route::get('productos', array('uses' => 'ProductoController@principal'));
Route::any('productos/listar_productos', array('uses' => 'ProductoController@listarProductos'));
Route::get('productos/agregar', array('uses' => 'ProductoController@agregarProducto'));
Route::get('productos/combobox', array('uses' => 'ProductoController@comboBox'));
Route::get('productos/num_codigo', array('uses' => 'ProductoController@numCodigo'));
Route::post('productos/guardar_producto', array('uses' => 'ProductoController@guardarProducto'));
Route::post('productos/eliminar_producto', array('uses' => 'ProductoController@eliminarProducto'));

Route::get('productos/ficha_producto', array('uses' => 'ProductoController@fichaProducto'));

//catalogos
Route::get('catalogos/elementocostoCRUD', array('uses' => 'CatalogosController@ElemntoCostoCRUD'));
Route::get('catalogos/comportamientoCRUD', array('uses' => 'CatalogosController@ComportamientoCRUD'));
Route::any('catalogos/tipo_productoCRUD', array('uses' => 'CatalogosController@TipoProductoCRUD'));
Route::any('catalogos/sub_tipo_productoCRUD', array('uses' => 'CatalogosController@SubTipoProductoCRUD'));
Route::any('catalogos/unidad_medidaCRUD', array('uses' => 'CatalogosController@UnidadMedidaCRUD'));

Route::get('catalogos/tipo_producto', array('uses' => 'CatalogosController@PrincipalTipoProducto'));
Route::get('catalogos/unidad_medida', array('uses' => 'CatalogosController@PrincipalUnidadMedida'));

?>

