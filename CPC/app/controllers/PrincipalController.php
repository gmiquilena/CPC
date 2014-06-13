<?php

/**
* 
*/
class PrincipalController extends BaseController{
	
	
	function index(){

		Session::put('key', '0');

		$html = View::make('general.cabezera', array('titulo' => 'Sistema de Control de Produccción'));
		$html.= View::make('principal');
		$html.= View::make('general.finHtml');

		return $html;

	}

}

?>