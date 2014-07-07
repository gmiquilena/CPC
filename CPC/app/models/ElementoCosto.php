<?php

/**
*   Modelo de elemento de costo
*/
class ElementoCosto extends Eloquent
{
	 protected $table = 'elemento_costo';

	 public function conceptosGastos()
	    {
	        return $this->hasMany('ConceptoGasto');
	    }
	 	 
}


?>