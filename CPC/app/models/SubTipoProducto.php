<?php

/**
*  
*/
class SubTipoProducto extends Eloquent
{
	protected $table = 'sub_tipo_producto';

	public function tipoProducto()
    {
      return $this->belongsTo('TipoProducto');
    }

    public function Productos()
	{
	 	return $this->hasMany('Producto');
	}
	
}


?>