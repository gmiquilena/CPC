<?php


/**
* 
*/
class ProductoController extends BaseController
{
	
	function principal(){

		$key = Session::get('key');
        Session::put('key', $key+1);

		$html = View::make('productos.principal', array('key' => $key));
        
        return $html;
	}

	function agregarProducto(){

		$key = Session::get('key');
        Session::put('key', $key+1);

		$html = View::make('productos.agregar', array('key' => $key));
        
        return $html;
	}

	function numCodigo(){

		$stpId=Input::get('id');
		$num = SubTipoProducto::find($stpId)->Productos()->count()+1;

		while (strlen($num)<3){
			$num="0".$num;
		}
		return $num;
	}

	function listarProductos(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1)*$rows;

		$total = Producto::all()->count();
		$productos = Producto::orderBy($sort,$order)->take($rows)->skip($offset)->get();

		foreach ($productos as $producto) {
			
			$lista[] = array('id' => $producto->id, 'codigo' => $producto->codigo , 'nombre' => $producto->nombre,
							 'unidad_medida' => $producto->unidadMedida->nombre , 'stock_min' => $producto->stock_min,
							 'stock_max' => $producto->stock_max);
		}
		
		return '{"total":"'.$total.'","rows":'.json_encode($lista).'}';	

	}

	function comboBox(){
		echo VistaProductos::all();
	}

	function guardarProducto(){

		$materiales = json_decode(Input::get('materiales'));
		$sub_tipo_prod = Input::get('sub_tipo_prod');
		$nombre=Input::get('nombre');
		$codigo=Input::get('codigo');
		$unidad_medida=Input::get('unidad_medida');
		$proceso=Input::get('proceso');
		$lote=Input::get('lote');
		$stock_min=Input::get('stock_min');
		$stock_max=Input::get('stock_max');
		$check_ficha=Input::get('check_ficha');

		if($stock_min=="")
			$stock_min=null;

		if($stock_max=="")
			$stock_max=null;

		$producto = new Producto();
		$producto->codigo = $codigo;
		$producto->nombre = $nombre;
		$producto->unidad_medida_id = $unidad_medida;
		$producto->stock_min = $stock_min;
		$producto->stock_max = $stock_max;
		$producto->sub_tipo_producto_id = $sub_tipo_prod;
		$producto->save();

		if($check_ficha=="true"){

			$ficha = new FichaProducto();
			$ficha->producto_id = $producto->id;
			$ficha->proceso_id = $proceso;
			$ficha->lote = $lote;
			$ficha->save();

			 foreach($materiales as $material)
			    {
			        $mat = new Materiales();

			        $mat->ficha_producto_id = $ficha->id;
			        $mat->producto_id = $material->id;
			        $mat->cantidad = $material->cantidad;
			        $mat->save();
			    }

			  return "Ficha de Producto Creada con Exito";  
		}
		 
		 return "Producto Creado con Exito";
	}

	function eliminarProducto(){
		$id=Input::get('id');
		$producto = Producto::find($id);
		$producto->delete();
		return "Se ha borrado el Producto con Exito";
	}

	function fichaProducto(){

		$id=Input::get('id');
		$producto = Producto::find($id);

		if($producto->fichaProducto == null){
				
			$lista = array('rows' => '', 'footer' => '{}');			
			return array('ficha' => 'null', 'materiales' => $lista);

		}

		$materiales = $producto->fichaProducto->Materiales;

		$costo_total_materiales = 0;
			foreach ($materiales as $material) {
					
					$costo_total = $material->Producto->costo_unitario*$material->cantidad;

					$costo_total_materiales+=$costo_total; 

					$listaMateriales[] = array('id' => $material->Producto->id, 'codigo' => $material->Producto->codigo,
											   'nombre' => $material->Producto->nombre, 'cantidad' => $material->cantidad,
											   'unidad_medida' => $material->Producto->unidadMedida->siglas,
											   'costo_unitario' => $material->Producto->costo_unitario, 
											   'costo_total' => $costo_total);

				}

				$footer[] = array('codigo' => 'Costo Total Materiales', 'costo_total' => $costo_total_materiales);
				
				$lista = array('rows' => $listaMateriales, 'footer' => $footer);	

		$ficha = array('proceso_id' => $producto->fichaProducto->Proceso->id,'proceso' => $producto->fichaProducto->Proceso->nombre,
					   'lote' => $producto->fichaProducto->lote, 'materiales' => $lista);

		return $ficha;

	}
	
}



?>