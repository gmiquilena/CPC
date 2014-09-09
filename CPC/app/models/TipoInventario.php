<?php

/**
*  
*/
class TipoInventario extends Eloquent
{
	protected $table = 'tipo_inventario';

	  public function Inventarios()
    {
      return $this->hasMany('Inventario');
    }
	
}


?>