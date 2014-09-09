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

        $ccostos=CentroCosto::all();
        $pccostos=$proceso->procesoCcosto;

       	
        foreach ($ccostos as $ccosto) {
        	$sw=true;

        	foreach ($pccostos as $pccosto) {		
        	
        		if($pccosto->centro_costo_id==$ccosto->id){
        			$sw=false;
        			break;
        		}
        	}

        	if($sw)
        	$listaCcosto[] = json_decode($ccosto);

        }


        //parametros para la vista de la tablaBasica        
        $params =  array('key' => $key, 'proceso' => $proceso, 
			        	 'tipo_producto' => $proceso->subTipoProducto->tipoProducto->nombre,
			        	 'sub_tipo_producto' => $proceso->subTipoProducto->nombre,
			        	 'ccostosJSON' => json_encode($listaCcosto));


        $html= View::make('procesos.proceso_ccostos',$params);


        //$html.= View::make('objetos.tablaMaestroDetalleCRUD', $params);
        

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

				
				$procesos = Proceso::orderBy($sort,$order)->take($rows)->skip($offset)->get();
				$total = sizeof($procesos);

				foreach ($procesos as $proceso) {
			
				$lista[] = array('id' => $proceso->id, 'codigo' => $proceso->codigo , 'nombre' => $proceso->nombre,
							 'descripcion' => $proceso->descripcion , 'tipo_producto' => $proceso->subTipoProducto->tipoProducto->nombre,
							 'sub_tipo_producto' => $proceso->subTipoProducto->nombre);
				}
					    
		        return '{"total":"'.$total.'","rows":'.json_encode($lista).'}';
				break;

			case 'c':

				$proceso = new Proceso();
				$proceso->codigo = Input::get('codigo');
				$proceso->nombre = Input::get('nombre');
				$proceso->descripcion = Input::get('descripcion');
				$proceso->sub_tipo_producto_id=Input::get('sub_tipo_producto');
				$proceso->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id=Input::get('id');
				$proceso = Proceso::find($id);
				$proceso->codigo = Input::get('codigo');
				$proceso->nombre = Input::get('nombre');
				$proceso->descripcion = Input::get('descripcion');
				$proceso->sub_tipo_producto_id=Input::get('sub_tipo_producto');
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

		$stp=Input::get('sub_tipo_producto_id');

		if($stp!="")
		echo Proceso::where('sub_tipo_producto_id','=',$stp)->get();
		else
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
		$idProceso = Input::get('id');

		$pccostos = ProcesoCcosto::where('proceso_id','=',$idProceso)->get();

		if(sizeof($pccostos)==0)
			return '{"total":0,"rows":[],"footer":[]}';

		$final_tiempo_total=0;

		foreach ($pccostos as $pccosto) {

		 	$ccosto = $pccosto->centroCosto;

		 		$tareas = $pccosto->tareas;
		 		$tiempoTotal=0;
		 		foreach ($tareas as $tarea) {
		 			
		 			$tg[] = array('id' => $pccosto->id.$tarea->id,'nombre' => $tarea->nombre, 
					'descripcion' => $tarea->descripcion, 'duracion' => $tarea->duracion ,
					'_parentId' => $pccosto->id,
					'state' => '');

					$tiempoTotal+=$tarea->duracion;
		 		}

		 	$final_tiempo_total+=$tiempoTotal;	
		 		
		 	$tg[] = array('id' => $pccosto->id,'nombre' => $ccosto->nombre, 
					'descripcion' => $ccosto->descripcion, 'duracion' => $tiempoTotal,
					'_parentId' => 0,
					'state' => 'closed');
		 		 	
		 }

		 $footer = array('nombre' => 'Total', 
					'duracion' => $final_tiempo_total,				
					'iconCls' => 'icon-sum');
		 		 
		 $total = sizeof($tg);
		 $tg = json_encode($tg);
		 $footer = json_encode($footer);

		 return '{"total":"'.$total.'","rows":'.$tg.',"footer":['.$footer.']}';	
	}


	/*
		arbol de costo de materia prima por centro de costo
	*/
	function treeGridCcostosMO(){
		 $idProceso = Input::get('id');

		 $pccostos = ProcesoCcosto::where('proceso_id','=',$idProceso)->get();

		 $final_tiempo_total=0;
		 $final_costo_total=0;

		 foreach ($pccostos as $pccosto) {

		 	$ccosto = $pccosto->centroCosto;
		 	$cgs=$ccosto->conceptosGastos()->where('elemento_costo_id', '=', 1)->get();

		 		$costo_real=0;
		 		$costo_estimado=0;

		 		foreach ($cgs as $cg) {
		 			$costo_real+=$cg->costo_real;
		 			$costo_estimado+=$cg->costo_estimado;
		 		}


		 		$tareas = $pccosto->tareas;
		 		$tiempoTotal=0;
		 		$costo_unitario=Util::calcularCostoTiempo($costo_real,'m');

		 		foreach ($tareas as $tarea) {
		 			
		 			
		 			$costo_total=$tarea->duracion*$costo_unitario;

		 			$tg[] = array('id' => $pccosto->id.$tarea->id,'nombre' => $tarea->nombre, 
					'descripcion' => $tarea->descripcion, 'duracion' => $tarea->duracion ,
					'costo_unitario' => round($costo_unitario,2), 'costo_total' => round($costo_total,2),
					'_parentId' => $pccosto->id,
					'state' => '');

					$tiempoTotal+=$tarea->duracion;
		 		}

		 	$costo_total=$tiempoTotal*$costo_unitario;

		 	$final_costo_total+=$costo_total;
		 	$final_tiempo_total+=$tiempoTotal;

		 	$tg[] = array('id' => $pccosto->id,'nombre' => $ccosto->nombre, 
					'descripcion' => $ccosto->descripcion, 'duracion' => $tiempoTotal,
					'costo_unitario' => round($costo_unitario,2), 'costo_total' => round($costo_total,2),
					'_parentId' => null,
					'state' => 'closed');
		 		 	
		 }


		 $footer = array('nombre' => 'Total', 
					'duracion' => $final_tiempo_total,
					'costo_total' => round($final_costo_total,2),
					'iconCls' => 'icon-sum');

		 		 
		 $total = sizeof($tg);
		 $tg = json_encode($tg);
		 $footer = json_encode($footer);
		 return '{"total":"'.$total.'","rows":'.$tg.',"footer":['.$footer.']}';
	}

	/*
		arbol de costo por fabricacion por centro de costo
	*/
	function treeGridCcostosGF(){
		 $idProceso = Input::get('id');

		 $pccostos = ProcesoCcosto::where('proceso_id','=',$idProceso)->get();

		 $final_tiempo_total=0;
		 $final_costo_total=0;

		 foreach ($pccostos as $pccosto) {

		 	$ccosto = $pccosto->centroCosto;
		 	$cgs=$ccosto->conceptosGastos()->where('elemento_costo_id', '=', 2)->get();

		 		$costo_real=0;
		 		$costo_estimado=0;

		 		foreach ($cgs as $cg) {
		 			$costo_real+=$cg->costo_real;
		 			$costo_estimado+=$cg->costo_estimado;
		 		}


		 		$tareas = $pccosto->tareas;
		 		$tiempoTotal=0;
		 		$costo_unitario=Util::calcularCostoTiempo($costo_real,'m');

		 		foreach ($tareas as $tarea) {
		 			
		 			
		 			$costo_total=$tarea->duracion*$costo_unitario;

		 			$tg[] = array('id' => $pccosto->id.$tarea->id,'nombre' => $tarea->nombre, 
					'descripcion' => $tarea->descripcion, 'duracion' => $tarea->duracion ,
					'costo_unitario' => round($costo_unitario,2), 'costo_total' => round($costo_total,2),
					'_parentId' => $pccosto->id,
					'state' => '');

					$tiempoTotal+=$tarea->duracion;
		 		}

		 	$costo_total=$tiempoTotal*$costo_unitario;

		 	$final_costo_total+=$costo_total;
		 	$final_tiempo_total+=$tiempoTotal;

		 	$tg[] = array('id' => $pccosto->id,'nombre' => $ccosto->nombre, 
					'descripcion' => $ccosto->descripcion, 'duracion' => $tiempoTotal,
					'costo_unitario' => round($costo_unitario,2), 'costo_total' => round($costo_total,2),
					'_parentId' => null,
					'state' => 'closed');
		 		 	
		 }


		 $footer = array('nombre' => 'Total', 
					'duracion' => $final_tiempo_total,
					'costo_total' => round($final_costo_total,2),
					'iconCls' => 'icon-sum');

		 		 
		 $total = sizeof($tg);
		 $tg = json_encode($tg);
		 $footer = json_encode($footer);
		 return '{"total":"'.$total.'","rows":'.$tg.',"footer":['.$footer.']}';
	}

	function costoProceso(){

		$idProceso = Input::get('id');

		 $pccostos = ProcesoCcosto::where('proceso_id','=',$idProceso)->get();

		 $final_tiempo_total=0;
		 $final_costo_total=0;

		 foreach ($pccostos as $pccosto) {

		 	$ccosto = $pccosto->centroCosto;
		 	$cgs=$ccosto->conceptosGastos()->where('elemento_costo_id', '=', 1)->get();

		 		$costo_real=0;
		 		$costo_estimado=0;

		 		foreach ($cgs as $cg) {
		 			$costo_real+=$cg->costo_real;
		 			$costo_estimado+=$cg->costo_estimado;
		 		}


		 		$tareas = $pccosto->tareas;
		 		$tiempoTotal=0;
		 		$costo_unitario=Util::calcularCostoTiempo($costo_real,'m');

		 		foreach ($tareas as $tarea) {
		 			
		 			
		 			$costo_total=$tarea->duracion*$costo_unitario;
		 			
					$tiempoTotal+=$tarea->duracion;
		 		}

		 	$costo_total=$tiempoTotal*$costo_unitario;

		 	$final_costo_total+=$costo_total;
		 	$final_tiempo_total+=$tiempoTotal;
		 	
		 		 	
		 }

		 $costo_mo=$final_costo_total;


		 $final_tiempo_total=0;
		 $final_costo_total=0;

		 foreach ($pccostos as $pccosto) {

		 	$ccosto = $pccosto->centroCosto;
		 	$cgs=$ccosto->conceptosGastos()->where('elemento_costo_id', '=', 2)->get();

		 		$costo_real=0;
		 		$costo_estimado=0;

		 		foreach ($cgs as $cg) {
		 			$costo_real+=$cg->costo_real;
		 			$costo_estimado+=$cg->costo_estimado;
		 		}


		 		$tareas = $pccosto->tareas;
		 		$tiempoTotal=0;
		 		$costo_unitario=Util::calcularCostoTiempo($costo_real,'m');

		 		foreach ($tareas as $tarea) {
		 				 			
		 			$costo_total=$tarea->duracion*$costo_unitario;

					$tiempoTotal+=$tarea->duracion;
		 		}

		 	$costo_total=$tiempoTotal*$costo_unitario;

		 	$final_costo_total+=$costo_total;
		 	$final_tiempo_total+=$tiempoTotal;
		 		 	
		 }

		 $costo_gf=$final_costo_total;


		 $costos = array("costo_mo"=>round($costo_mo,2),"costo_gf"=>round($costo_gf,2));
		 			 		 
		 return json_encode($costos);

	}

	function ccostosProceso(){

		 $idProceso = Input::get('id');

		 if ($idProceso==0)
		 	return '[]';

		 $proceso = Proceso::find($idProceso);

		 $pccostos = $proceso->procesoCcosto;


		 foreach ($pccostos as $pcc) {
		 	
		 	$lista[] = array('id' => $pcc->centroCosto->id, 'nombre' => $pcc->centroCosto->nombre);

		 }

		 return json_encode($lista);

	}
	


}