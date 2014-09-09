<?php

/**
*   
*/
class MovimientosInv extends Eloquent
{
	 protected $table = 'movimientos_inv';

	public function tipoMovimiento()
    {
        return $this->belongsTo('TipoMovimiento');
    }
	 	 
}


?>