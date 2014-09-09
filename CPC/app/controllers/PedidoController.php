<?php


/**
* 
*/
class PedidoController extends BaseController
{
	
	function principal(){

		$key = Session::get('key');
        Session::put('key', $key+1);

		$html = View::make('pedidos.principal', array('key' => $key));
        
        return $html;
	}

	function agregarPedido(){

		$key = Session::get('key');
        Session::put('key', $key+1);

		$html = View::make('pedidos.agregar', array('key' => $key));
        
        return $html;

	}

	function planificacion(){

		$key = Session::get('key');
        Session::put('key', $key+1);

		$html = View::make('pedidos.planificacion', array('key' => $key));
        
        return $html;

	}

	function treePedidosProducto(){

		$idProducto=Input::get('idProducto');

		$clientes = Pedido::buscarclientesItem($idProducto);

		$cantidad_pedida = 0;

		foreach ($clientes as $cliente) {
			
			$cantidad_cliente = 0;

			$pedidos = Pedido::buscarItemPedidosCliente($idProducto,$cliente->id); 

				foreach ($pedidos as $pedido) {

					$date = new DateTime($pedido->fecha_pedido);
		 			
		 			$tg[] = array('id' => $pedido->num_item,'cliente_pedido' => Util::formatItemPedido($pedido->num_item), 
					'cantidad' => $pedido->cantidad, 'cant_pedida' => $pedido->cantidad, '_parentId' => $cliente->id, 
					'fecha_pedido' => $date->format('d/m/Y'),
					'state' => '', 'item_pedido_id' => $pedido->id);

					$cantidad_cliente+=$pedido->cantidad;
		 		}

		 	$cantidad_pedida+=$cantidad_cliente;
		 		
		 	$tg[] = array('id' => $cliente->id, 'cliente_pedido' => $cliente->nombre, 
					'cantidad' => $cantidad_cliente, 'cant_pedida' => $cantidad_cliente,
					'_parentId' => 0,
					'state' => 'closed', 'iconCls' => 'icon-persona');

		}

		$footer = array('cliente_pedido' => 'Total', 
					'cantidad' => $cantidad_pedida,
					'cant_pedida' => $cantidad_pedida,				
					'iconCls' => 'icon-sum');
		 		 
		 $total = sizeof($tg);
		 $tg = json_encode($tg);
		 $footer = json_encode($footer);

		 return '{"total":"'.$total.'","rows":'.$tg.',"footer":['.$footer.']}';	


	}

	function listarMaterialesProducto(){
		
		$idProducto=Input::get('idProducto');
		$cant_pedida=Input::get('cant_pedida');

		$resumen = Pedido::ResumenProducto($idProducto);
        
        foreach ($resumen as $res) {
        	        
	           	$aux_cant=$res->cant_inventario;
	           	$fabricar=0;
            	while($aux_cant<$cant_pedida){

            		$aux_cant+=$res->lote;
            		$fabricar+=$res->lote;

            	}

			$cant_lotes = $fabricar/$res->lote;

		}

		$materiales = Pedido::materialesProducto($idProducto);

		foreach ($materiales as $mat) {

            		$cant_requerida = $cant_lotes * $mat->cant_ficha;
            		$mat2[] = array('codigo' => $mat->codigo, 'nombre' => $mat->nombre, 'unidad_medida' => $mat->unidad_medida,
            						'cant_requerida' => $cant_requerida, 'stock' => $mat->stock); 		            		

            	}

		$total = sizeof($mat2);

		return '{"total":"'.$total.'","rows":'.json_encode($mat2).'}';	

	}


	function resumenPedidos(){

		$resumen = Pedido::Resumen();
            $total = sizeof($resumen);

            foreach ($resumen as $res) {
            	
	           	$aux_cant=$res->cant_inventario;
	           	$fabricar=0;
            	while($aux_cant<$res->cant_pedida){

            		$aux_cant+=$res->lote;
            		$fabricar+=$res->lote;

            	}

            	$lista[] = array('id' => $res->id, 'codigo' => $res->codigo, 'nombre' => $res->nombre, 'cant_inventario' => $res->cant_inventario,
            		'cant_pedida' => $res->cant_pedida, 'lote' => $res->lote, 'fabricar' => $fabricar);



            }

			return '{"total":"'.$total.'","rows":'.json_encode($lista).'}';	
	}	


	function PedidoCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':

				$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
				$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
				$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
				$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
				$offset = ($page-1)*$rows;

				$total = Pedido::all()->count();
				$pedidos = Pedido::orderBy($sort,$order)->take($rows)->skip($offset)->get();

				foreach ($pedidos as $pedido) {
			
					$date = new DateTime($pedido->fecha_pedido);

					$estado = Util::estadoItemPedido($pedido->estado);

					$lista[] = array('id' => $pedido->id, 'num_pedido' => $pedido->id, 'cliente' => $pedido->Cliente->nombre , 
						'fecha_pedido' => $date->format('d/m/Y'), 'estado' => $estado);
				}

				if($total==0)
				   return '{"total":"'.$total.'","rows":[]}';
		       
		        return '{"total":"'.$total.'","rows":'.json_encode($lista).'}';
				break;

			case 'c':
				
				$pedido = new Pedido();
				$date = new DateTime(Input::get('fecha_pedido'));
				$items = json_decode(Input::get('items'));
				
				$pedido->cliente_id = Input::get('cliente');
				$pedido->fecha_pedido = $date->format('Y-m-d H:i:s');
				$pedido->save();

				$i=1;

				foreach ($items as $item) {

					$auxItem = new ItemPedido();
					$auxItem->pedido_id=$pedido->id;
					$auxItem->num_item=$i;
					$auxItem->producto_id=$item->id;
					$auxItem->cantidad=$item->cantidad;
					$auxItem->nota=$item->nota;					
					$auxItem->save();
					
					$i++;
				}

				return "Pedido Creado con Exito";

				break;

			case 'u':

				$id = Input::get('id');
				$pedidos = Pedido::find($id);
				$pedidos->cliente_id = Input::get('cliente');
				$pedidos->fecha_pedido = Input::get('fecha_pedido');
				$pedidos->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$pedidos = Pedido::find($id);
				$pedidos->delete();
				echo json_encode(array('success'=>true));
				break;				
			
		}

	}

	function ItemsCRUD(){

		$param=Input::get('param');

		switch ($param) {
			case 'r':

				//NO ESTA SIENDO USADO
				$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
				$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
				$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'num_item';
				$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
				$offset = ($page-1)*$rows;


				$id=Input::get('id');
				$pedido = Pedido::find($id);

				$total = $pedido->Items->count();
				$items = $pedido->Items;

				foreach ($items as $item) {
			
					
					$estado = Util::estadoItemPedido($item->estado);					

					$lista[] = array('id' => $item->id, 'cod_producto' => $item->Producto->codigo, 'producto' => $item->Producto->nombre, 
						'cantidad' => $item->cantidad, 'nota' => $item->nota,'estado' => $estado);
				}


				if($total==0)
				   return '{"total":"'.$total.'","rows":[]}';
		       
		        return '{"total":"'.$total.'","rows":'.json_encode($lista).'}';
				break;

			case 'c':
				
				$pedido = new Pedido();
				$date = new DateTime(Input::get('fecha_pedido'));
				$items = json_decode(Input::get('items'));
				
				$pedido->cliente_id = Input::get('cliente');
				$pedido->fecha_pedido = $date->format('Y-m-d H:i:s');
				$pedido->save();

				$i=1;

				foreach ($items as $item) {

					$auxItem = new ItemPedido();
					$auxItem->pedido_id=$pedido->id;
					$auxItem->num_item=$i;
					$auxItem->producto_id=$item->id;
					$auxItem->cantidad=$item->cantidad;
					$auxItem->nota=$item->nota;

					$auxItem->save();
					
					$i++;
				}

				return "Pedido Creado con Exito";

				break;

			case 'u':

				$id = Input::get('id');
				$pedidos = Pedido::find($id);
				$pedidos->cliente_id = Input::get('cliente');
				$pedidos->fecha_pedido = Input::get('fecha_pedido');
				$pedidos->save();
				echo json_encode(array('success'=>true));
				break;
			
			case 'd':

				$id=Input::get('id');
				$pedidos = Pedido::find($id);
				$pedidos->delete();
				echo json_encode(array('success'=>true));
				break;				
			
		}

	}
}

?>