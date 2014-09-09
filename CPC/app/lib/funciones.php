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

	public static function estadoItemPedido($num){

		switch ($num) {
				
			case 0:
				return 'NUEVO';					

			case 1:
				return 'FABRICACION';
					
			case 2:
				return 'COMPLETADO';
					
			case 3:
				return 'ANULADO';

			default:
				return $num;

		}
	}


	public static function estadoOp($num){
		

		switch ($num) {
				
			case 0:
				return 'NUEVA';					

			case 1:
				return 'FABRICACION';
			
			case 2:
				return 'DETENIDO';

			case 3:
				return 'COMPLETADO';
					
			case 4:
				return 'CANCELADO';

			default:
				return $num;
		}
	}

	public static function formatItemPedido($num){

		$array = explode("-",$num);

	    $result=$array[0];

	    while(strlen($result)<10)
	        $result='0'.$result;

	    $result=$result.'-'.$array[1];
	    
	    return $result;

	}

	public static function formatOp($num){

		while(strlen($num)<8)
	        $num='0'.$num;

	    return "OP".$num;

	}

	public static function formatFecha($fecha){
		
		$date = new DateTime($fecha);
		return $date->format('d/m/Y');
	}

	public static function formatFechaHora($fecha){
		
		$date = new DateTime($fecha);
		return $date->format('d/m/Y - H:i:s');
	}


}



?>