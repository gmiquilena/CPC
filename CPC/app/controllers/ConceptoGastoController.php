<?php


/**
* 
*/
class ConceptoGastoController extends BaseController{

	function CRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':

				$id = Input::get('id');
				$cg = CentroCosto::find($id)->conceptosGastos; 				

				if(sizeof($cg)==0){
					return '{"total":0,"rows":[],"footer":[]}';
				} 

				$total_mano_obra = 0;
				$total_mano_obra_est = 0;
				$total_gasto_fabrica = 0;
				$total_gasto_fabrica_est = 0;

				$total_costo_real = 0;
				$total_costo_estimado = 0;


				foreach ($cg as $cg) {
					$cgf[] = array('id' => $cg->id,'codigo' => $cg->codigo, 
					'descripcion' => $cg->descripcion, 'costo_real' => $cg->costo_real ,
					'costo_estimado' => $cg->costo_estimado,
					'elemento_costo' => $cg->elementoCosto->nombre,
					'comportamiento' => $cg->comportamiento->nombre);

					if($cg->elementoCosto->id==1){
						$total_mano_obra+=$cg->costo_real;
						$total_mano_obra_est+=$cg->costo_estimado;	
					}
					

					if($cg->elementoCosto->id==2){
						$total_gasto_fabrica+=$cg->costo_real;
						$total_gasto_fabrica_est+=$cg->costo_estimado;
					}
					

					$total_costo_real+=$cg->costo_real;
					$total_costo_estimado+=$cg->costo_estimado;

				}

				$cgf=json_encode($cgf);

		        $total = sizeof($cgf);
		        
		        return '{"total":"'.$total.'","rows":'.$cgf.
		        ',"footer":[{"descripcion":"Costo Mano de Obra:","costo_real":"'.$total_mano_obra.'","costo_estimado":"'.$total_mano_obra_est.'"},
		        			{"descripcion":"Costo de Fabricación:","costo_real":"'.$total_gasto_fabrica.'","costo_estimado":"'.$total_gasto_fabrica_est.'"},
		        			{"descripcion":"Costo Total:","costo_real":"'.$total_costo_real.'","costo_estimado":"'.$total_costo_estimado.'"}]}';

				break;

			case 'c':
				$idCcosto = Input::get('id');
				$cg = new ConceptoGasto();
				$cg->codigo = Input::get('codigo');
				$cg->descripcion = Input::get('descripcion');
				$cg->costo_real = Input::get('costo_real');
				$cg->costo_estimado = Input::get('costo_estimado');
				$cg->elemento_costo_id = Input::get('elemento_costo');
				$cg->comportamiento_id = Input::get('comportamiento');
				$cg->centro_costo_id = $idCcosto;
				$cg->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id = Input::get('id');
				$cg = ConceptoGasto::find($id);
				$cg->codigo = Input::get('codigo');
				$cg->descripcion = Input::get('descripcion');
				$cg->costo_real = Input::get('costo_real');
				$cg->costo_estimado = Input::get('costo_estimado');
				$cg->elemento_costo_id = Input::get('elemento_costo');
				$cg->comportamiento_id = Input::get('comportamiento');				
				$cg->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$cg = ConceptoGasto::find($id);
				$cg->delete();
				echo json_encode(array('success'=>true));
				break;
			
		}

	}

	function comboBox(){

		echo ConceptoGasto::all();

	}


}



?>