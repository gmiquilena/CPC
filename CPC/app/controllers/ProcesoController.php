<?php

require('../clases/ClasesTabla.php');

/**
* 
*/
class ProcesoController extends BaseController{


	function principal(){



		//Columnas
        $codigo = new ColumnaCRUD("Codigo","codigo","true","true","","20px");
        $nombre = new ColumnaCRUD("Nombre","nombre","true","true");
        $descripcion = new ColumnaCRUD("Descripción","descripcion");
       
        $colMaestro = array($codigo,$nombre,$descripcion);
        

        //definicion de parametros de la tabla
        $maestro = new tablaCRUD("Procesos de Fabricación","procesos/CRUD","auto","300px","Proceso de Fabricación");



        //Columnas
        $codigo = new ColumnaCRUD("Codigo","codigo","true","true","","20px");
        $nombre = new ColumnaCRUD("Nombre","nombre","true","true");
        $descripcion = new ColumnaCRUD("Descripción","descripcion");
       
        $colDetalle = array($codigo,$nombre,$descripcion);
        

        //definicion de parametros de la tabla
        $detalle = new tablaCRUD("Centros de Costos","maquinas/CRUD","auto","250px","Maquina/Estación");


        $key = Session::get('key');
        Session::put('key', $key+1);

        //parametros para la vista de la tablaBasica        
        $params =  array('maestro' => $maestro, 'colMaestro' => $colMaestro, 
        				 'detalle' => $detalle, 'colDetalle' => $colDetalle, 'key' => $key);


        //armando la pagina que se va a mostrar
        $html = View::make('general.cabezera', array('titulo' => 'Centros de Costos'));
        $html.= View::make('procesos.principal', $params);
        $html.= View::make('general.finHtml');

        return $html;



	}

	function addccostos(){
		

        $key = Session::get('key');
        Session::put('key', $key+1);

        $id=Input::get('id');
        $proceso = Proceso::find($id);

        //parametros para la vista de la tablaBasica        
        $params =  array('key' => $key, 'proceso' => $proceso);


        $html= View::make('procesos.proceso_ccostos',$params);


        //$html.= View::make('objetos.tablaMaestroDetalleCRUD', $params);
        

        return $html;

	}

	function CRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':
				
				$proceso = Proceso::all(); 
		        $total = sizeof($proceso);
		        return '{"total":"'.$total.'","rows":'.$proceso.'}';
				break;

			case 'c':

				$proceso = new Proceso();
				$proceso->codigo = Input::get('codigo');
				$proceso->nombre = Input::get('nombre');
				$proceso->descripcion = Input::get('descripcion');
				$proceso->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id=Input::get('id');
				$proceso = Proceso::find($id);
				$proceso->codigo = Input::get('codigo');
				$proceso->nombre = Input::get('nombre');
				$proceso->descripcion = Input::get('descripcion');
				$proceso->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$proceso = Proceso::find($id);
				$proceso->delete();
				echo json_encode(array('success'=>true));
				break;
			
		}

	}


	function comboBox(){

		echo Proceso::all();

	}

	function crearProcesoCcosto(){

		$id=Input::get('idProceso');
		$ccosto=Input::get('ccosto');

		$pccostos=new ProcesoCcosto();
		$pccostos->proceso_id=$id;
		$pccostos->centro_costo_id=$ccosto;
		$pccostos->save();



     	$tareas = json_decode(Input::get('tareas'));
	    
	    foreach($tareas as $tarea)
	    {

	    	$newtarea = new Tarea();
			$newtarea->nombre = $tarea->nombre;
			$newtarea->duracion = $tarea->duracion;
			$newtarea->descripcion = $tarea->descripcion;
			$newtarea->proceso_ccosto_id = $pccostos->id;
			$newtarea->save();		    

	    }


		return json_encode(array('success'=>true));

	}

	function eliminarProcesoCcosto(){

		$id=Input::get('id');
		$pccostos = ProcesoCcosto::find($id);
		$pccostos->delete();
		echo json_encode(array('success'=>true));
	}


	function treeGridCcostos(){
		 $id = Input::get('id');
		 $tree = VistaCcostosTareas::where('proceso_id', '=', $id)->get();
		 $total = sizeof($tree);
		 return '{"total":"'.$total.'","rows":'.$tree.'}';		
	}



}