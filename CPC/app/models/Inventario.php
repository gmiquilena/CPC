<?php

/**
*  
*/
class Inventario extends Eloquent
{
	protected $table = 'inventario';

	public function Producto()
    {
      return $this->belongsTo('Producto');
    }

    public function TipoInventario()
    {
      return $this->belongsTo('TipoInventario');
    }    
	
}


?>