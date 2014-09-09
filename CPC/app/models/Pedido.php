<?php

/**
*  
*/
class Pedido extends Eloquent
{
	protected $table = 'pedido';

	
	public function Cliente()
    {
        return $this->belongsTo('Cliente');
    }

    public function Items()
    {
    	return $this->hasMany('ItemPedido','pedido_id', 'id');
    }
    
    //para el resumen general de pedidos por producto    
    public static function Resumen(){

       return DB::select(DB::raw("SELECT 
                                  producto.id,
                                  producto.codigo, 
                                  producto.nombre, 
                                  inventario.cantidad AS cant_inventario, 
                                  SUM(item_pedido.cantidad) AS cant_pedida, 
                                  ficha_producto.lote
                                FROM 
                                  producto, 
                                  item_pedido, 
                                  ficha_producto, 
                                  inventario
                                WHERE 
                                  producto.id = inventario.producto_id AND
                                  producto.id = item_pedido.producto_id AND
                                  item_pedido.estado = 0 AND
                                  ficha_producto.producto_id = producto.id
                                GROUP BY
                                  producto.id,
                                  producto.codigo, 
                                  producto.nombre, 
                                  inventario.cantidad,
                                  ficha_producto.lote "));
    }

    //resumen de pedidos de un solo producto
    public static function ResumenProducto($idProducto){

       return DB::select(DB::raw("SELECT 
                                  producto.id,
                                  producto.codigo, 
                                  producto.nombre, 
                                  inventario.cantidad AS cant_inventario, 
                                  SUM(item_pedido.cantidad) AS cant_pedida, 
                                  ficha_producto.lote
                                FROM 
                                  producto, 
                                  item_pedido, 
                                  ficha_producto, 
                                  inventario
                                WHERE 
                                  producto.id = inventario.producto_id AND
                                  producto.id = item_pedido.producto_id AND
                                  item_pedido.estado = 0 AND
                                  ficha_producto.producto_id = producto.id AND
                                  producto.id = $idProducto
                                GROUP BY
                                  producto.id,
                                  producto.codigo, 
                                  producto.nombre, 
                                  inventario.cantidad,
                                  ficha_producto.lote "));
    }
 
    // todos los clientes que piden un producto
    public static function buscarclientesItem($idProducto){

        return DB::select(DB::raw("SELECT DISTINCT
                                    cliente.id,
                                    cliente.nombre
                                  FROM 
                                    public.pedido, 
                                    public.item_pedido, 
                                    public.producto, 
                                    public.cliente
                                  WHERE 
                                    pedido.id = item_pedido.pedido_id AND
                                    pedido.cliente_id = cliente.id AND
                                    item_pedido.producto_id = producto.id AND
                                    item_pedido.estado = 0 AND
                                    producto.id = $idProducto"));


    }

    // todos los pedidos de un cliente con un producto
    public static function buscarItemPedidosCliente($idProducto,$idCliente){

        return DB::select(DB::raw("SELECT 
                                    pedido.id || '-' || item_pedido.num_item AS num_item,                                    
                                    item_pedido.cantidad,
                                    pedido.fecha_pedido,
                                    item_pedido.id                                    
                                  FROM 
                                    public.pedido, 
                                    public.item_pedido, 
                                    public.producto, 
                                    public.cliente
                                  WHERE 
                                    pedido.id = item_pedido.pedido_id AND
                                    pedido.cliente_id = cliente.id AND
                                    item_pedido.producto_id = producto.id AND
                                    item_pedido.estado = 0 AND
                                    producto.id = $idProducto AND cliente.id=$idCliente"));


    }
    
    // todos los materiales disponibles para fabricar un producto
    public static function materialesProducto($idProducto){

          return DB::select(DB::raw("SELECT 
                                      producto.codigo, 
                                      producto.nombre, 
                                      unidad_medida.siglas AS unidad_medida, 
                                      (inventario.cantidad - inventario.cant_comprometida) AS stock, 
                                      materiales.cantidad AS cant_ficha
                                    FROM 
                                      public.inventario, 
                                      public.producto, 
                                      public.unidad_medida, 
                                      public.ficha_producto, 
                                      public.materiales
                                    WHERE 
                                      producto.id = inventario.id AND
                                      unidad_medida.id = producto.unidad_medida_id AND
                                      ficha_producto.id = materiales.ficha_producto_id AND
                                      materiales.producto_id = producto.id AND
                                      ficha_producto.producto_id = $idProducto"));

    }
	
}


?>