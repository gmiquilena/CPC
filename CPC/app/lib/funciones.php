<?php

/**
* 
*/
class Util
{
	
	function __construct()
	{
		
	}

	public static function calcularCostoTiempo($costo,$unidad){

		$costo_dia=$costo/30;
		$costo_hora=$costo_dia/8;
		$costo_minuto=$costo_hora/60;

		switch ($unidad) {
			
			case 'm':return $costo_minuto;					
			
			case 'h':return $costo_hora;

			case 'd':return $costo_dia;

			default: return $costo_minuto;
				
		}

	}
}



?>