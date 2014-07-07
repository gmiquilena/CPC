<?php

require('../clases/ClasesTabla.php');

/**
* 
*/
class CentrocostoController extends BaseController{


	function principal(){



		//Columnas
        $codigo = new ColumnaCRUD("Codigo","codigo","true","true","","20px");
        $nombre = new ColumnaCRUD("Nombre","nombre","true","true");
        $descripcion = new ColumnaCRUD("Descripción","descripcion");
       
        $colMaestro = array($codigo,$nombre,$descripcion);
        

        //definicion de parametros de la tabla
        $maestro = new tablaCRUD("Centros de Costos","ccostos/CRUD","auto","300px","Centro de Costo");



        //Columnas
        $codigo = new ColumnaCRUD("Codigo","codigo","true","true","","20px");
        $nombre = new ColumnaCRUD("Nombre","nombre","true","true");
        $descripcion = new ColumnaCRUD("Descripción","descripcion");
       
        $colDetalle = array($codigo,$nombre,$descripcion);
        

        //definicion de parametros de la tabla
        $detalle = new tablaCRUD("Maquinas/Estaciones","maquinas/CRUD","auto","250px","Maquina/Estación");


        $key = Session::get('key');
        Session::put('key', $key+1);

        //parametros para la vista de la tablaBasica        
        $params =  array('maestro' => $maestro, 'colMaestro' => $colMaestro, 
        				 'detalle' => $detalle, 'colDetalle' => $colDetalle, 'key' => $key);


        //armando la pagina que se va a mostrar
        $html = View::make('general.cabezera', array('titulo' => 'Centros de Costos'));
        $html.= View::make('ccostos.principal', $params);
        $html.= View::make('general.finHtml');

        return $html;



	}


	function CRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':
				
				$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
				$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
				$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'codigo';
				$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
				$offset = ($page-1)*$rows;

				$total = CentroCosto::all()->count();
				$cc = CentroCosto::orderBy($sort,$order)->take($rows)->skip($offset)->get();
		       
		        return '{"total":"'.$total.'","rows":'.$cc.'}';
				break;

			case 'c':

				$cc = new CentroCosto();
				$cc->codigo = Input::get('codigo');
				$cc->nombre = Input::get('nombre');
				$cc->descripcion = Input::get('descripcion');
				$cc->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id=Input::get('id');
				$cc = CentroCosto::find($id);
				$cc->codigo = Input::get('codigo');
				$cc->nombre = Input::get('nombre');
				$cc->descripcion = Input::get('descripcion');
				$cc->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$cc = CentroCosto::find($id);
				$cc->delete();
				echo json_encode(array('success'=>true));
				break;
			
		}

	}


	function comboBox(){

		echo CentroCosto::all();

	}


}




?>