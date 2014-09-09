 <div class="easyui-panel" title="Nueva Orden de Produccìón" style="width:auto">
        <div style="padding:2px">
            <table cellpadding="5">
                <tr>

                    <td>Orden de Producción:</td>
                    <td>
                       <input id="orden_produccion_{{$key}}" class='in-disabled' disabled="true" name="orden_produccion"></input>
                    </td>

                    <td>Nº de Pedido:</td>
                    <td>
                       <input id="pedido_{{$key}}" name="pedido" class='in-disabled' disabled="true"></input>
                    </td>

                    <td>Lote:</td>
                    <td>
                       <input id="lote_{{$key}}" class='in-numerico in-disabled' disabled="true" value="{{$producto->fichaProducto->lote}}"></input>
                    </td>
                    
                 </tr>

                 <tr>

                    <td>Codigo de Producto:</td>
                    <td>
                       <input id="codigo_{{$key}}" name="pedido" value="{{$producto->codigo}}" class='in-disabled' disabled="true"></input>
                    </td>

                    <td>Producto:</td>
                    <td>
                       <input id="producto_{{$key}}" name="producto" style="width:300px" class='in-disabled' disabled="true" value="{{$producto->nombre}}"></input>
                    </td>

                    <td>Cantidad a Fabricar:</td>
                    <td>
                       <input id="cant_pedida_{{$key}}" value="{{$item->cantidad}}" class="easyui-numberbox in-numerico" data-options="min:0,precision:3"></input>
                    </td>
                    <td>
                        {{$producto->unidadMedida->siglas}}
                    </td>                   

                 </tr>

                 <tr>

                    <td>Fecha de Orden:</td>
                    <td>
                        <input class="easyui-datebox" required="true" id="fecha_op_{{$key}}" name="fecha_op"></input>
                    </td>

                    <td>Nota/Comentario:</td>
                    <td colspan='4'>
                       <textarea id="nota_{{$key}}" style="width:100%">{{$item->nota}}</textarea>
                    </td>
                 </tr>   
            </table>                    

         </div>          
    </div>

    <div style="text-align:right;padding:5px; width:auto">
           <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar_op_{{$key}}()">Guardar</a>
           <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"onclick="reloadTab('pedidos')">Cancelar</a>
    </div> 

    <script>

        
        lote_{{$key}}={{$producto->fichaProducto->lote}};
        

        $("#pedido_{{$key}}").val(formatCodigo('{{$pedido->id}}',null)+'-{{$item->num_item}}');
        $("#orden_produccion_{{$key}}").val(formatOp('{{$op}}',null)); 

        function guardar_op_{{$key}}(){

            fecha=$("#fecha_op_{{$key}}").datebox('getValue'); 
            cantidad=$("#cant_pedida_{{$key}}").val();
            nota=$("#nota_{{$key}}").val();

            if(cantidad==""){
                mensajeAlerta("Debe ingresar la Cantidad de la Orden");
                return;
            }

            res=cantidad%lote_{{$key}} //da 1 

            if(res!=0){
                mensajeAlerta("la cantidad a fabricar debe ser multiplo del lote");
                return;   
            }

            if(fecha==""){
                mensajeAlerta("Debe ingresar la Fecha de la Orden de Producción");
                return;
            }

            // Realizamos la petición al servidor
            
            $.post('orden_produccion/CRUD?param=c', {item_pedido: {{$item->id}}, producto: {{$producto->id}},fecha:fecha,
                    cantidad:cantidad,nota:nota},
                function(respuesta) {
                     mensajeInfo(respuesta);
                     reloadTab('pedidos');
            }).error(
                function(){
                     mensajeError('Error al Crear Orden de Producción');
                }
            );
        }       

    </script>