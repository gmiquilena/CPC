<?php

/**
*   Modelo de concepto de gasto
*/
class ConceptoGasto extends Eloquent
{
	 protected $table = 'concepto_gasto';

	public function elementoCosto()
    {
        return $this->belongsTo('ElementoCosto');
    }

    public function comportamiento()
    {
        return $this->belongsTo('Comportamiento');
    }
	 	 
}


?>