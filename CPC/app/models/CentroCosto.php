<?php

/**
*   Modelo de Centro de Costos
*/
class CentroCosto extends Eloquent
{
	 protected $table = 'centro_costo';
	 
	 public function maquinas()
	    {
	        return $this->hasMany('Maquina');
	    }
}


?>