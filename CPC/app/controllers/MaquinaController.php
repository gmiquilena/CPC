<?php


/**
* 
*/
class MaquinaController extends BaseController{

	function CRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':
				$id = Input::get('id');

				$maquina = CentroCosto::find($id)->maquinas; 
		        $total = sizeof($maquina);
		        return '{"total":"'.$total.'","rows":'.$maquina.'}';
				break;

			case 'c':
				$idCcosto = Input::get('id');
				$maquina = new Maquina();
				$maquina->codigo = Input::get('codigo');
				$maquina->nombre = Input::get('nombre');
				$maquina->descripcion = Input::get('descripcion');
				$maquina->centro_costo_id = $idCcosto;
				$maquina->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id = Input::get('id');
				$maquina = Maquina::find($id);
				$maquina->codigo = Input::get('codigo');
				$maquina->nombre = Input::get('nombre');
				$maquina->descripcion = Input::get('descripcion');
				$maquina->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$maquina = Maquina::find($id);
				$maquina->delete();
				echo json_encode(array('success'=>true));
				break;
			
		}

	}

	function comboBox(){

		echo Maquina::all();

	}


}



?>