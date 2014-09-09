<?php

/**
*  
*/
class Materiales extends Eloquent
{
	protected $table = 'materiales';

	public function Producto()
    {
      return $this->belongsTo('Producto');
    }

    public function CentroCosto()
    {
      return $this->belongsTo('CentroCosto');
    }
	
}


?>