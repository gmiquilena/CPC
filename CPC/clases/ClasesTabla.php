<?php

class Tabla{

	
    var $titulo; //titulo de la tabla
    var $url;    //url donde buscar el json
    var $ancho;  //ancho de la tabla
    var $alto;   //alto de la tabla

	function __construct($titulo,$url,$ancho = '500px',$alto = '250px'){

		$this->titulo=$titulo;
		$this->url=$url;
		$this->ancho=$ancho;
		$this->alto=$alto;
	}

}

class Columna{

	var $titulo; //titulo de la columna
	var $campo;  //nombre del campo en el json
	var $ancho;  //ancho de la columna

	function __construct($titulo,$campo,$ancho = '100px'){

		$this->titulo=$titulo;
		$this->campo=$campo;
		$this->ancho=$ancho;
	}
}


/**
* 
*/
class TablaCRUD{

	var $titulo; //titulo de la tabla
    var $url;    //url donde buscar el json {c=crear,r=leer,u=actualizar,d=eliminar}
    var $updateUrl;  //url donde buscar el json
    var $ancho;  //ancho de la tabla
    var $alto;   //alto de la tabla
    var $tituloForm;   //titulo para los formularios CRUD
   	
	function __construct($titulo,$url,$ancho = '500px',$alto = '250px',$tituloForm = 'Registro'){

		$this->titulo=$titulo;
		$this->url=$url;
		$this->ancho=$ancho;
		$this->alto=$alto;
		$this->tituloForm=$tituloForm;
	}
}

class ColumnaCRUD{

	var $titulo; //titulo de la columna
	var $campo;  //nombre del campo en el json
	var $ancho;  //ancho de la columna
	var $editable;
	var $required;
	var $class;
	var $validType;
	var $select;
	var $urlSelect;

	function __construct($titulo,$campo,$editable = "true",$required = "false",$validType = "",$ancho = '100px'){

		$this->titulo=$titulo;
		$this->campo=$campo;
		$this->editable=$editable;
		$this->ancho=$ancho;
		$this->required=$required;

		if ($required=="true" || $validType!="")
			$this->class="easyui-validatebox";


	}

}



?>