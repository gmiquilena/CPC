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


//centros de costos
Route::get('ccostos', array('uses' => 'CentrocostoController@principal'));
Route::post('ccostos/CRUD', array('uses' => 'CentrocostoController@CRUD'));
Route::get('ccostos/combobox', array('uses' => 'CentrocostoController@comboBox'));

//procesos
Route::get('procesos', array('uses' => 'ProcesoController@principal'));
Route::post('procesos/CRUD', array('uses' => 'ProcesoController@CRUD'));
Route::get('procesos/combobox', array('uses' => 'ProcesoController@comboBox'));
Route::get('procesos/addccostos', array('uses' => 'ProcesoController@addccostos'));
Route::post('procesos/crearpccostos', array('uses' => 'ProcesoController@crearProcesoCcosto'));
Route::post('procesos/eliminarpccostos', array('uses' => 'ProcesoController@eliminarProcesoCcosto'));
Route::get('procesos/treeccostos', array('uses' => 'ProcesoController@treeGridCcostos'));

//maquinas
Route::post('maquinas/CRUD', array('uses' => 'MaquinaController@CRUD'));

//tareas
Route::post('tareas/CRUD', array('uses' => 'TareaController@CRUD'));



?>

