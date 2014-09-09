<?php

/**
*  
*/
class TipoProducto extends Eloquent
{
	 protected $table = 'tipo_producto';

	 public function SubTipoProductos()
	 {
	 	return $this->hasMany('SubTipoProducto');
	 }
	
}


?>