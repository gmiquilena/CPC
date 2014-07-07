<?php

/**
*   Modelo de comportamiento del concepto de gasto
*/
class Comportamiento extends Eloquent
{
	 protected $table = 'comportamiento';

	 public function conceptosGastos()
	    {
	        return $this->hasMany('ConceptoGasto');
	    }
	 	 
}


?>