<?php

require('../clases/ClasesTabla.php');
/**
* 
*/
class CatalogosController extends BaseController{

	function principalTipoProducto(){

		//Columnas
        $codigo = new ColumnaCRUD("Codigo","codigo","true","true","","20px");
        $nombre = new ColumnaCRUD("Nombre","nombre","true","true");
        $descripcion = new ColumnaCRUD("Descripción","descripcion");
       
        $colMaestro = array($codigo,$nombre,$descripcion);
        

        //definicion de parametros de la tabla
        $maestro = new tablaCRUD("Tipos de Producto","catalogos/tipo_productoCRUD","auto","300px","Tipo de Producto");



        //Columnas
        $codigo = new ColumnaCRUD("Codigo","codigo","true","true","","20px");
        $nombre = new ColumnaCRUD("Nombre","nombre","true","true");
        $descripcion = new ColumnaCRUD("Descripción","descripcion");
       
        $colDetalle = array($codigo,$nombre,$descripcion);
        

        //definicion de parametros de la tabla
        $detalle = new tablaCRUD("Sub-Tipos de Producto","catalogos/sub_tipo_productoCRUD","auto","250px","Sub-Tipo de Producto");


        $key = Session::get('key');
        Session::put('key', $key+1);

        //parametros para la vista de la tablaBasica        
        $params =  array('maestro' => $maestro, 'colMaestro' => $colMaestro, 
        				 'detalle' => $detalle, 'colDetalle' => $colDetalle, 'key' => $key);


        //armando la pagina que se va a mostrar
        $html= View::make('objetos.tablaMaestroDetalleCRUD', $params);
       
        return $html;
	}

	function principalUnidadMedida(){

		//Columnas
        $nombre = new ColumnaCRUD("Nombre","nombre","true","true");
        $siglas = new ColumnaCRUD("Siglas","siglas","true","true");
        $descripcion = new ColumnaCRUD("Descripción","descripcion");
       
        $columnas = array($nombre,$siglas,$descripcion);
        

        //definicion de parametros de la tabla
        $tabla = new tablaCRUD("Unidades de Medida","catalogos/unidad_medidaCRUD","auto","300px","Unidad de Medida");

        
        $key = Session::get('key');
        Session::put('key', $key+1);

        //parametros para la vista de la tablaBasica        
        $params =  array('tabla' => $tabla, 'columnas' => $columnas, 'key' => $key);


        //armando la pagina que se va a mostrar
        $html= View::make('objetos.tablaCRUD', $params);
       
        return $html;
	}


	function ElemntoCostoCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':

				 $ec = ElementoCosto::all(); 				

				 return $ec;

				break;

			case 'c':
				
				$ec = new ElementoCosto();
				$ec->nombre = Input::get('nombre');
				$ec->descripcion = Input::get('descripcion');
				$ec->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id = Input::get('id');
				$ec = ElementoCosto::find($id);
				$ec->nombre = Input::get('nombre');
				$ec->descripcion = Input::get('descripcion');
				$ec->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$ec = ElementoConcepto::find($id);
				$ec->delete();
				echo json_encode(array('success'=>true));
				break;
			
		}

	}

	

	function ComportamientoCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':				 
				$comp = Comportamiento::all(); 				
				return $comp;
				break;

			case 'c':
				
				$comp = new Comportamiento();
				$comp->nombre = Input::get('nombre');
				$comp->descripcion = Input::get('descripcion');
				$comp->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id = Input::get('id');
				$comp = Comportamiento::find($id);
				$comp->nombre = Input::get('nombre');
				$comp->descripcion = Input::get('descripcion');
				$comp->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$comp = Comportamiento::find($id);
				$comp->delete();
				echo json_encode(array('success'=>true));
				break;
			
		}

	}

	function TipoProductoCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':		

				return TipoProducto::all();
				break;

			case 'c':
				
				$stp = new TipoProducto();
				$stp->codigo = Input::get('codigo');
				$stp->nombre = Input::get('nombre');
				$stp->descripcion = Input::get('descripcion');
				$stp->save();
				return json_encode(array('success'=>true));
				break;

			case 'u':

				$id=Input::get('id');
				$stp = TipoProducto::find($id);
				$stp->codigo = Input::get('codigo');
				$stp->nombre = Input::get('nombre');
				$stp->descripcion = Input::get('descripcion');
				$stp->save();
				return json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$stp = TipoProducto::find($id);
				$stp->delete();
				return json_encode(array('success'=>true));
				break;
			
		}

	}	

	function SubTipoProductoCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':				 
				$id=Input::get('id');
				$tp = TipoProducto::find($id);
				return $tp->SubTipoProductos;
				break;

			case 'c':
				
				$tp=Input::get('id');
				$stp = new SubTipoProducto();
				$stp->codigo = Input::get('codigo');
				$stp->nombre = Input::get('nombre');
				$stp->descripcion = Input::get('descripcion');
				$stp->tipo_producto_id = $tp;
				$stp->save();
				return json_encode(array('success'=>true));
				break;

			case 'u':

				$id=Input::get('id');
				$tp=Input::get('tipo_producto');
				$stp = SubTipoProducto::find($id);
				$stp->codigo = Input::get('codigo');
				$stp->nombre = Input::get('nombre');
				$stp->descripcion = Input::get('descripcion');
				$stp->tipo_producto_id = $tp;
				$stp->save();
				return json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$stp = SubTipoProducto::find($id);
				$stp->delete();
				return json_encode(array('success'=>true));
				break;
			
		}

	}

	function UnidadMedidaCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':				 
				return UnidadMedida::all();
				break;

			case 'c':
								
				$um = new UnidadMedida();
				$um->siglas = Input::get('siglas');
				$um->nombre = Input::get('nombre');
				$um->descripcion = Input::get('descripcion');
				$um->save();
				return json_encode(array('success'=>true));
				break;

			case 'u':

				$id=Input::get('id');
				$um = UnidadMedida::find($id);
				$um->siglas = Input::get('siglas');
				$um->nombre = Input::get('nombre');
				$um->descripcion = Input::get('descripcion');				
				$um->save();
				return json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$um = UnidadMedida::find($id);
				$um->delete();
				return json_encode(array('success'=>true));
				break;
			
		}

	}

	
}



?>