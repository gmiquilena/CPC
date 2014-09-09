<?php

/**
*  
*/
class OrdenProduccion extends Eloquent
{
	protected $table = 'orden_produccion';

	
	public function ItemPedido()
    {
        return $this->belongsTo('ItemPedido');
    }

    public function Producto()
    {
        return $this->belongsTo('Producto');
    }

    public static function pedidosOP($op){

        return DB::select(DB::raw("SELECT 
                                    cliente.nombre, 
                                    pedido.id || '-' || item_pedido.num_item AS num_item, 
                                    item_pedido.cantidad AS cant_pedida,
                                    item_pedido_op.cantidad AS cant_asignada   
                                  FROM 
                                    public.orden_produccion, 
                                    public.item_pedido_op, 
                                    public.item_pedido, 
                                    public.pedido, 
                                    public.cliente, 
                                    public.producto, 
                                    public.unidad_medida
                                  WHERE 
                                    orden_produccion.id = item_pedido_op.orden_produccion_id AND
                                    orden_produccion.producto_id = producto.id AND
                                    item_pedido_op.item_pedido_id = item_pedido.id AND
                                    pedido.id = item_pedido.pedido_id AND
                                    pedido.cliente_id = cliente.id AND
                                    producto.unidad_medida_id = unidad_medida.id AND 
                                    orden_produccion.id = $op"));


    }

    public static function materialesOP($op){

        return DB::select(DB::raw("SELECT
                                      producto.id, 
                                      producto.codigo, 
                                      producto.nombre, 
                                      unidad_medida.siglas, 
                                      round( CAST (float8 (orden_produccion.cantidad_ped/ficha_producto.lote) * materiales.cantidad as numeric), 2) AS cantidad                                      
                                    FROM 
                                      public.orden_produccion, 
                                      public.ficha_producto, 
                                      public.materiales, 
                                      public.producto, 
                                      public.unidad_medida
                                    WHERE 
                                      orden_produccion.producto_id = ficha_producto.producto_id AND
                                      ficha_producto.id = materiales.ficha_producto_id AND
                                      materiales.producto_id = producto.id AND
                                      producto.unidad_medida_id = unidad_medida.id AND
                                      orden_produccion.id = $op"));


    }

    public static function opsCentroCosto($idCc){

      return DB::select(DB::raw("SELECT 
                                  orden_produccion.id, 
                                  producto.codigo, 
                                  producto.nombre, 
                                  control_produccion.cantidad,
                                  control_produccion.id AS control_prod_id
                                FROM 
                                  public.centro_costo, 
                                  public.control_produccion, 
                                  public.orden_produccion, 
                                  public.producto
                                WHERE 
                                  centro_costo.id = control_produccion.centro_costo_id AND
                                  control_produccion.orden_produccion_id = orden_produccion.id AND
                                  producto.id = orden_produccion.producto_id AND 
                                  centro_costo.id = $idCc"));

    }

    public static function ccostosProceso($op){

      return DB::select(DB::raw("SELECT 
                                  centro_costo.id, 
                                  centro_costo.nombre
                                FROM 
                                  public.orden_produccion, 
                                  public.ficha_producto, 
                                  public.proceso, 
                                  public.proceso_ccosto, 
                                  public.centro_costo
                                WHERE 
                                  orden_produccion.producto_id = ficha_producto.producto_id AND
                                  ficha_producto.proceso_id = proceso.id AND
                                  proceso_ccosto.proceso_id = proceso.id AND
                                  proceso_ccosto.centro_costo_id = centro_costo.id AND
                                  centro_costo.tipo_centro_costo_id=1 AND
                                  orden_produccion.id = $op
                                ORDER BY
                                  proceso_ccosto.id ASC"));


    }

  public static function movimientosOP($op){

    return DB::select(DB::raw("SELECT 
                                centro_costo.nombre AS centro_costo, 
                                movimientos_inv.fecha_mov AS fecha, 
                                tipo_movimiento.nombre AS movimiento, 
                                movimientos_inv.cantidad AS cantidad
                              FROM 
                                public.movimientos_inv, 
                                public.centro_costo, 
                                public.tipo_movimiento
                              WHERE 
                                movimientos_inv.centro_costo_id = centro_costo.id AND
                                movimientos_inv.tipo_movimiento_id = tipo_movimiento.id AND
                                movimientos_inv.num_ref = $op
                              ORDER BY
                                movimientos_inv.fecha_mov ASC"));
  }
    
	
}


?>