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
        $codigo = new ColumnaCRUD("Codigo","codigo","true","true","20px");
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

	function principalCliente(){

		//Columnas
		$codigo = new ColumnaCRUD("Codigo","id","false","false","20px");
		$nombre = new ColumnaCRUD("Nombre","nombre","true","true");
        $rif = new ColumnaCRUD("Rif","rif","true","true");
        $direccion = new ColumnaCRUD("Dirección","direccion");
       
        $columnas = array($codigo,$nombre,$rif,$direccion);
        

        //definicion de parametros de la tabla
        $tabla = new tablaCRUD("Clientes","catalogos/clienteCRUD","auto","300px","Cliente");

        
        $key = Session::get('key');
        Session::put('key', $key+1);

        //parametros para la vista de la tablaBasica        
        $params =  array('tabla' => $tabla, 'columnas' => $columnas, 'key' => $key);


        //armando la pagina que se va a mostrar
        $html= View::make('objetos.tablaCRUD', $params);
       
        return $html;
	}

	function principalInventario(){

		
        
        $key = Session::get('key');
        Session::put('key', $key+1);

        //parametros para la vista de la tablaBasica        
        $params =  array('key' => $key);


        //armando la pagina que se va a mostrar
        $html= View::make('inventario.principal', $params);
       
        return $html;
	}


	function ClienteCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':

				$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
				$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
				$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'nombre';
				$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
				$offset = ($page-1)*$rows;

				$total = Cliente::all()->count();
				$clientes = Cliente::orderBy($sort,$order)->take($rows)->skip($offset)->get();
		       
		        return '{"total":"'.$total.'","rows":'.$clientes.'}';
				break;

			case 'c':
				
				$cliente = new Cliente();
				$cliente->nombre = Input::get('nombre');
				$cliente->rif = Input::get('rif');
				$cliente->direccion = Input::get('direccion');
				$cliente->save();
				echo json_encode(array('success'=>true));
				break;

			case 'u':

				$id = Input::get('id');
				$cliente = Cliente::find($id);
				$cliente->rif = Input::get('rif');
				$cliente->direccion = Input::get('direccion');
				$cliente->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$cliente = Cliente::find($id);
				$cliente->delete();
				echo json_encode(array('success'=>true));
				break;

			case 'combo':

				return Cliente::all();			
			
		}

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
				$tp=Input::get('idMaestro');
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

	function InventarioCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':

				$tipo_inv=Input::get('tipo_inv');

				$inv = Inventario::where('tipo_inventario_id', '=', $tipo_inv)->get();

				foreach ($inv as $i) {

					$prod = $i->Producto;

					$lista[] = array('id' => $i->id, 'codigo' => $prod->codigo, 'nombre' => $prod->nombre,
									 'unidad_medida' => $prod->unidadMedida->siglas,
									 'cantidad' => $i->cantidad, 'cant_comprometida' => $i->cant_comprometida, 
									 'cant_disponible' => ($i->cantidad - $i->cant_comprometida));

				}

				$total = sizeof($inv);

				if($total==0)
					return '[]';
				
		        return '{"total":"'.$total.'","rows":'.json_encode($lista).'}';
				

			case 'c':
								
				
				break;

			case 'u':

				
				break;
			
			case 'd':

				
				break;
			
		}

	}

	function TipoInventarioCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':				 
				return TipoInventario::all();				

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


	function TipoCcostosCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':				 
				return TipoCentroCosto::all();				

			case 'c':
			
				break;

			case 'u':

				break;
			
			case 'd':

				break;
			
		}

	}



	
}



?>