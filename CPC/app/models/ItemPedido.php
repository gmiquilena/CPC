<?php

/**
*  
*/
class ItemPedido extends Eloquent
{
	protected $table = 'item_pedido';

	
	public function Pedido()
    {
        return $this->belongsTo('Pedido');
    }

    public function Producto()
    {
        return $this->belongsTo('Producto');
    }
	
}