<?php

/**
*   
*/
class ProcesoCcosto extends Eloquent
{
	 protected $table = 'proceso_ccosto';
	 
	public function centroCosto()
    {
      return $this->belongsTo('CentroCosto');
    }

    public function proceso()
    {
      return $this->belongsTo('Proceso');
    }

	public function tareas()
	{
	  return $this->hasMany('Tarea');
	}
}


?>