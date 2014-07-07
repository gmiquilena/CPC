<?php

/**
*  
*/
class FichaProducto extends Eloquent
{
	protected $table = 'ficha_producto';

	public function Materiales()
	{
	 	return $this->hasMany('Materiales');
	}

	public function Proceso()
    {
        return $this->belongsTo('Proceso');
    }
	
}


?>