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
