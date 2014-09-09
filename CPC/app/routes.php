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
Route::any('escritorio/mensajes', array('uses' => 'EscritorioController@cargarMensajes'));


//centros de costos
Route::get('ccostos', array('uses' => 'CentrocostoController@principal'));
Route::post('ccostos/CRUD', array('uses' => 'CentrocostoController@CRUD'));
Route::get('ccostos/combobox', array('uses' => 'CentrocostoController@comboBox'));
Route::get('ccostos/combobox_prod', array('uses' => 'CentrocostoController@comboBoxProductivo'));

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
Route::get('procesos/ccostos_proceso', array('uses' => 'ProcesoController@ccostosProceso'));

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
Route::any('catalogos/clienteCRUD', array('uses' => 'CatalogosController@ClienteCRUD'));
Route::any('catalogos/tipo_inventarioCRUD', array('uses' => 'CatalogosController@TipoInventarioCRUD'));
Route::any('catalogos/inventarioCRUD', array('uses' => 'CatalogosController@InventarioCRUD'));
Route::any('catalogos/tipo_ccostosCRUD', array('uses' => 'CatalogosController@TipoCcostosCRUD'));

Route::get('catalogos/tipo_producto', array('uses' => 'CatalogosController@PrincipalTipoProducto'));
Route::get('catalogos/unidad_medida', array('uses' => 'CatalogosController@PrincipalUnidadMedida'));
Route::get('catalogos/cliente', array('uses' => 'CatalogosController@PrincipalCliente'));
Route::get('catalogos/inventario', array('uses' => 'CatalogosController@PrincipalInventario'));

//Pedidos
Route::get('pedidos', array('uses' => 'PedidoController@principal'));
Route::get('pedidos/agregar', array('uses' => 'PedidoController@agregarPedido'));
Route::get('pedidos/planificacion', array('uses' => 'PedidoController@planificacion'));
Route::any('pedidos/CRUD', array('uses' => 'PedidoController@PedidoCRUD'));
Route::any('pedidos/itemsCRUD', array('uses' => 'PedidoController@ItemsCRUD'));
Route::get('pedidos/tree_pedido_producto', array('uses' => 'PedidoController@treePedidosProducto'));
Route::any('pedidos/resumen_pedidos', array('uses' => 'PedidoController@resumenPedidos'));
Route::any('pedidos/materiales_producto', array('uses' => 'PedidoController@listarMaterialesProducto'));


//Orden de Producion
Route::get('orden_produccion', array('uses' => 'OrdenProduccionController@principal'));
Route::get('orden_produccion/agregar', array('uses' => 'OrdenProduccionController@agregar'));
Route::any('orden_produccion/CRUD', array('uses' => 'OrdenProduccionController@CRUD'));
Route::post('orden_produccion/guardar_op_planificacion', array('uses' => 'OrdenProduccionController@guardarOpPlanificacion'));
Route::get('orden_produccion/reporte', array('uses' => 'OrdenProduccionController@reporteOP'));
Route::post('orden_produccion/fabricar', array('uses' => 'OrdenProduccionController@fabricar'));
Route::get('orden_produccion/produccion', array('uses' => 'OrdenProduccionController@produccion'));
Route::post('orden_produccion/ops_centro_costo', array('uses' => 'OrdenProduccionController@opsCentroCosto'));
Route::post('orden_produccion/procesar', array('uses' => 'OrdenProduccionController@procesar'));
?>

