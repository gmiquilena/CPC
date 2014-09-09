function redondeo(numero, decimales)
{
    var flotante = parseFloat(numero);
    var resultado = Math.round(flotante*Math.pow(10,decimales))/Math.pow(10,decimales);
    return resultado;
}

function mensajeInfo(msj){
    $.messager.alert('Mensaje',msj,'info');
}

function mensajeError(msj){
    $.messager.alert('Mensaje',msj,'error');
}

function mensajeAlerta(msj){
    $.messager.alert('Mensaje',msj,'warning');
}


function mayus(elem,event){

	tecla=(document.all) ? event.keyCode : event.which;
	
	//<- -> inico fin
    if(tecla==37 || tecla==39 || tecla==36 || tecla==35)
        return;
            
    $(elem).val($(elem).val().toUpperCase());
}

function formatCodigo(val,row){
    
    var str = val.toString();

        while(str.length<10)
        str='0'+str;

    
    return str;
    
}

function formatItemPedido(val,row){
    
   
    var array = val.split("-");

    var result=array[0];

    while(result.length<10)
        result='0'+result;

    result=result+'-'+array[1];
    
    return result;
    
}

function formatOp(val,row){
    
    var str = val.toString();

        while(str.length<8)
        str='0'+str;

        str='OP'+str;

    
    return str;
    
}

function formatCantidad(val,row){
    
    var str = val.toString();

    var array = str.split(".");

    var entero = array[0];
    var decimal = array[1];

    if(decimal==null)
        decimal="";

        while(decimal.length<3)
        decimal+='0';

        str=entero+'.'+decimal;

    
    return str;
    
}

function formatCosto(val,row){
    
    var str = val.toString();

    var array = str.split(".");

    var entero = array[0];
    var decimal = array[1];

    if(decimal==null)
        decimal="";

        while(decimal.length<2)
        decimal+='0';

        str=entero+'.'+decimal;

    
    return str;
    
}

