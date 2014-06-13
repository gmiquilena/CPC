<?php

/**
*   
*/
class ProcesoCcosto extends Eloquent
{
	 protected $table = 'proceso_ccosto';
	 
	 public function tareas()
	    {
	        return $this->hasMany('Tarea');
	    }
}


?>