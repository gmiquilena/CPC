<?php

require('../clases/ClasesTabla.php');

/**
* 
*/
class TareaController extends BaseController{

	function CRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':
				$id = Input::get('id');

				$tareas = ProcesoCcosto::find($id)->tareas; 
		        $total = sizeof($tareas);
		        return '{"total":"'.$total.'","rows":'.$tareas.'}';
				break;

			case 'c':
				$idProcesoCcosto = Input::get('id');
				$tarea = new Tarea();
				$tarea->nombre = Input::get('nombre');
				$tarea->duracion = Input::get('duracion');
				$tarea->descripcion = Input::get('descripcion');
				$tarea->proceso_ccosto_id = $idProcesoCcosto;
				$tarea->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id = Input::get('id');
				$tarea =Tarea::find($id);
				$tarea->nombre = Input::get('nombre');
				$tarea->duracion = Input::get('duracion');
				$tarea->descripcion = Input::get('descripcion');
				$tarea->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$tarea =Tarea::find($id);
				$tarea->delete();
				echo json_encode(array('success'=>true));
				break;
			
		}

	}

	function comboBox(){

		echo Tarea::all();

	}


}



?>