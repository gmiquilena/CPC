<?php


/**
* 
*/
class EscritorioController extends BaseController{


	function principal(){
		
		$inventario = Inventario::all();

		foreach ($inventario as $inv) {
			
			$producto = $inv->Producto;

			if ($producto->stock_min==$inv->cantidad)
				$lista[] = array('codigo' => $producto->codigo, 
								 'nombre' => $producto->nombre,
								 'tipo' => 'alert',
								 'text' => 'Stock igual al Minimo');

			if ($producto->stock_min>$inv->cantidad)
				$lista[] = array('codigo' => $producto->codigo, 
								 'nombre' => $producto->nombre,
								 'tipo' => 'critico',
								 'text' => 'Stock menor al Minimo');

			if ($producto->stock_max<$inv->cantidad)
				$lista[] = array('codigo' => $producto->codigo, 
								 'nombre' => $producto->nombre,
								 'tipo' => 'info',
								 'text' => 'Stock mayor que el Maximo');


		}

		if(sizeof($inventario)==0)
		$mensajes = "[]";			
		else
		$mensajes = $lista;

		return View::make('escritorio',array('mensajes' => $mensajes));
	}

	
	function cargarMensajes(){

		$inventario = Inventario::all();

		foreach ($inventario as $inv) {
			
			$producto = $inv->Producto;

			if ($producto->stock_min==$inv->cantidad)
				$lista[] = array('codigo' => $producto->codigo, 
								 'nombre' => $producto->nombre,
								 'tipo' => 'alert',
								 'text' => 'El Inventario es Igual al Stock Minimo');

			if ($producto->stock_min>$inv->cantidad)
				$lista[] = array('codigo' => $producto->codigo, 
								 'nombre' => $producto->nombre,
								 'tipo' => 'critico',
								 'text' => 'El Inventario es menor al Stock Minimo');

			if ($producto->stock_max<$inv->cantidad)
				$lista[] = array('codigo' => $producto->codigo, 
								 'nombre' => $producto->nombre,
								 'tipo' => 'info',
								 'text' => 'El Inventario es mayor al Stock Maximo');


		}

		return json_encode($lista);

	}


}