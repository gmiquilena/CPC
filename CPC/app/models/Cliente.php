<?php

/**
*  
*/
class Cliente extends Eloquent
{
	protected $table = 'cliente';

	public function Pedidos()
	{
	 	return $this->hasMany('Pedido');
	}

}


?>