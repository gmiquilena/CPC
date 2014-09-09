<?php

/**
*   Modelo de Centro de Costos
*/
class Proceso extends Eloquent
{
	protected $table = 'proceso';

	public function subTipoProducto()
    {
      return $this->belongsTo('SubTipoProducto');
    }

    public function procesoCcosto()
	{
	  return $this->hasMany('ProcesoCcosto');
	}

		 
}


?>