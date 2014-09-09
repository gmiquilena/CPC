<?php


/**
* 
*/
class OrdenProduccionController extends BaseController
{

    function principal(){

        $key = Session::get('key');
        Session::put('key', $key+1);
                
        $html = View::make('ordenProduccion.principal', array('key' => $key));
        
        return $html;

    }

    function produccion(){
        $key = Session::get('key');
        Session::put('key', $key+1);
                
        $html = View::make('ordenProduccion.produccion', array('key' => $key));
        
        return $html;        
    }

    function reporteOP(){

        $key = Session::get('key');
        Session::put('key', $key+1);
        
        $num_op=Input::get('op');

        $op = OrdenProduccion::find($num_op);
        $pedidos=OrdenProduccion::pedidosOP($num_op);
        $materiales=OrdenProduccion::materialesOP($num_op);
        $movimientos=OrdenProduccion::movimientosOP($num_op);

        $html = View::make('ordenProduccion.reporte', array('key' => $key, 'op' => $op,
                           'pedidos' => $pedidos, 'materiales' => $materiales,
                           'movimientos' => $movimientos));
        
        return $html;

    }



	function agregar(){

		$key = Session::get('key');
        Session::put('key', $key+1);

        $id=Input::get('idItem');

        $item = ItemPedido::find($id);
        $pedido = $item->Pedido;
        $producto = $item->producto;

        $aux = OrdenProduccion::orderBy('id')->take(1)->get();

         if($aux=="[]")
         	$op = 0;
         else
        	$op = $aux[0]->id;

        $op++;

		$html = View::make('ordenProduccion.agregar', array('key' => $key,'item' => $item,
						   'pedido' => $pedido, 'producto' => $producto, 'op' => $op));
        
        return $html;
	}

    function CRUD(){

              $param=Input::get('param');

                switch ($param) {
                        case 'r':
                                
                                $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
                                $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
                                $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
                                $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
                                $offset = ($page-1)*$rows;

                                
                                $ops = OrdenProduccion::orderBy($sort,$order)->take($rows)->skip($offset)->get();
                                $total = sizeof($ops);

                                foreach ($ops as $op) {
                                    
                                $estado = Util::estadoOp($op->estado);

                                $lista[] = array('id' => $op->id, 'codigo' => $op->Producto->codigo, 
                                'producto' => $op->Producto->nombre, 'estado' => $estado,
                                'cantidad_ped' => $op->cantidad_ped, 'cantidad_term' => $op->cantidad_term);
                                }

                                            
                                return '{"total":"'.$total.'","rows":'.json_encode($lista).'}';                                

                        case 'c':

                                $op = new OrdenProduccion();
                                $op->item_pedido_id = Input::get('item_pedido');
                                $op->fecha_orden = Input::get('fecha');
                                $op->producto_id = Input::get('producto');
                                $op->nota=Input::get('nota');
                                $op->cantidad_ped=Input::get('cantidad');
                                $op->save();

                                $item=$op->ItemPedido;

                                $item->estado=1;
                                $item->save();

                                $pedido=$item->Pedido;

                                if($pedido->estado==0){
                                    $pedido->estado=1;
                                    $pedido->save();
                                }

                                return "Orden de Produccion Creada";

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

    function guardarOpPlanificacion(){

        $op = new OrdenProduccion();
        
        //$op->fecha_orden = Input::get('fecha');
        $op->producto_id = Input::get('producto_id');
        //$op->nota=Input::get('nota');
        $op->cantidad_ped=Input::get('cantidad_op');
        $op->save();

        $pedidos=json_decode(Input::get('pedidos'));


        foreach ($pedidos as $pedido) {
            
            if($pedido->_parentId==0 || $pedido->cantidad<=0)
                continue;

            $ipOP = new ItemPedidoOP();
            $ipOP->item_pedido_id = $pedido->item_pedido_id;
            $ipOP->orden_produccion_id = $op->id;
            $ipOP->cantidad = $pedido->cantidad;
            $ipOP->save();


            $item= ItemPedido::find($pedido->item_pedido_id);

            $item->estado=1;
            $item->save();

            $pedido=$item->Pedido;

                if($pedido->estado==0){
                    $pedido->estado=1;
                    $pedido->save();
                }    
        }


        $materiales = OrdenProduccion::materialesOP($op->id);

        foreach ($materiales as $mat) {


            $producto = Producto::find($mat->id);

            $inv = $producto->inventario;            

            $inv->cant_comprometida=$inv->cant_comprometida+$mat->cantidad;
            $inv->save();
        }

        

        return "Orden de Produccion Creada ".Util::formatOp($op->id);


    }

    function fabricar(){

        $num_op = Input::get('op');

        $op = OrdenProduccion::find($num_op);

        $materiales = OrdenProduccion::materialesOP($op->id);

        foreach ($materiales as $mat) {
            
            $producto = Producto::find($mat->id);

            $inv = $producto->inventario;

            $inv->cantidad = $inv->cantidad-$mat->cantidad;
            $inv->cant_comprometida = $inv->cant_comprometida-$mat->cantidad;

            $inv->save();

        }

        $ccostos = OrdenProduccion::ccostosProceso($op->id);

                $newcp = new ControlProduccion();
                $newcp->centro_costo_id = $ccostos[0]->id;
                $newcp->orden_produccion_id = $op->id;
                $newcp->cantidad = $op->cantidad_ped;

                $newcp->save();


        $op->estado=1;
        $op->save();

        return "Orden de Producción ".Util::formatOp($op->id)." Iniciada";

    }

    function opsCentroCosto(){

        $idCc = Input::get('ccosto');

        $ops = OrdenProduccion::opsCentroCosto($idCc);

        return json_encode($ops);
    }

    function procesar(){

        $cp_id = Input::get('control_prod');
        $cantidad = Input::get('cantidad');

        $cp = ControlProduccion::find($cp_id);

        $cp->cantidad=$cp->cantidad-$cantidad;

        $ccostos = OrdenProduccion::ccostosProceso($cp->orden_produccion_id);

        $sw = -1;

        $op = OrdenProduccion::find($cp->orden_produccion_id);

        foreach ($ccostos as $ccosto) {
            
            if($sw==0){

                $newcp = new ControlProduccion();
                $newcp->centro_costo_id = $ccosto->id;
                $newcp->orden_produccion_id = $cp->orden_produccion_id;
                $newcp->cantidad = $cantidad;

                $newcp->save();

                $sw=1;
                
                break;
            }

            if($ccosto->id==$cp->centro_costo_id)
                $sw=0;

        }

        if($sw==0){
            
            $op->cantidad_term=$op->cantidad_term+$cantidad;

            if($op->cantidad_term==$op->cantidad_ped)
                $op->estado=3;

            $op->save();


            $producto = Producto::find($op->producto_id);

            $inv = $producto->inventario;
            $inv->cantidad = $inv->cantidad+$cantidad;
            $inv->save();

            $mov = new MovimientosInv();
            $mov->producto_id = $op->producto_id;
            $mov->tipo_movimiento_id = 2;
            $mov->num_ref = $op->id;
            $mov->cantidad = $cantidad;
            $mov->centro_costo_id = $cp->centro_costo_id;
            $mov->save();

        }
        else
        {
            $mov = new MovimientosInv();
            $mov->producto_id = $op->producto_id;
            $mov->tipo_movimiento_id = 1;
            $mov->num_ref = $op->id;
            $mov->cantidad = $cantidad;
            $mov->centro_costo_id = $cp->centro_costo_id;
            $mov->save();            
        }


        if($cp->cantidad==0)
            $cp->delete();
        else
            $cp->save();

        return "Procesado";

    }


}