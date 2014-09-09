<?php

/**
*  
*/
class Producto extends Eloquent
{
	protected $table = 'producto';

	public function unidadMedida()
    {
      return $this->belongsTo('UnidadMedida');
    }

    public function fichaProducto()
    {
        return $this->hasOne('FichaProducto');
    }

    public function subTipoProducto()
    {
      return $this->belongsTo('SubTipoProducto');
    }

    public function inventario()
    {
        return $this->hasOne('Inventario');
    }

  
}


?>