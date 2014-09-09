<table id="dgOp_{{$key}}" title="Producción por Centro de Costo" class="easyui-datagrid" style="width:auto;height:380px"
            toolbar="#toolbar_{{$key}}" pagination="true"
             sortName="id" sortOrder="asc"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
            
                <th data-options="field:'id',width:50" sortable="true" formatter="formatOp">Nº de Orden</th>
                <th data-options="field:'codigo',width:50">Codigo Prod</th>
                <th data-options="field:'nombre',width:100">Producto</th>
                <th data-options="field:'cantidad',width:50,align:'right'" formatter="formatCantidad">Cantidad Recibida</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar_{{$key}}">
       <table>
        <tr>
            <td>
                Centro de Costo:
            </td>
            <td>
                <input class="easyui-combobox" style="width:200px" id="combo_ccosto{{$key}}" data-options="url:'ccostos/combobox_prod',
                                                    method:'get',
                                                    valueField:'id',
                                                    textField:'nombre',
                                                    panelHeight:'auto',
                             "> 
            </td>
        </tr>
        <tr>
            <td>
                <a href="javascript:void(0)" id="btn_fabricar_{{$key}}" disabled='true' class="easyui-linkbutton" iconCls="icon-proceso" plain="true" onclick="abrir_procesar_{{$key}}()">Procesar</a>
            </td>
            <td>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ordenes" plain="true" onclick="detalle_orden_{{$key}}()">Ver</a>
            </td>
        </tr>
       </table>

    </div>

    <div id="win_{{$key}}" class="easyui-window" title="Orden de Producción" data-options="modal:true,closed:true,iconCls:'icon-ordenes'"
             style="width:780px;height:600px">
        
    </div>

    <div id="win_procesar{{$key}}" class="easyui-window" title="Procesar Orden" data-options="modal:true,closed:true,iconCls:'icon-proceso'" style="width:400px;height:150px">

        <table align="center" class="tablaForm">

            <tr>
                <td>Cantidad Procesada:</td>
                <td><input id="cant_procesada_{{$key}}" class="easyui-numberbox in-numerico" data-options="min:0,precision:3"></td>
            </tr>

            <tr>
                <td colspan="2" align="center"><a href="javascript:void(0)" class="easyui-linkbutton" onclick="procesar_orden_{{$key}}()">Aceptar</a></td>
            </tr>   


        </table>

    </div>

    <script>

        var op_{{$key}} = -1;
        var control_prod_{{$key}} = null;        

        $('#dgOp_{{$key}}').datagrid({
                            onClickRow: function(index,data){
                                op_{{$key}} = data.id;
                                $("#cant_procesada_{{$key}}").val(formatCantidad(data.cantidad,null));
                                $('#btn_fabricar_{{$key}}').linkbutton('enable');

                                control_prod_{{$key}} = data.control_prod_id;
                          }
                        });

        function detalle_orden_{{$key}}(){


            if(op_{{$key}}>0){
                $('#win_{{$key}}').window('open');
                $('#win_{{$key}}').window('refresh', 'orden_produccion/reporte?op='+op_{{$key}});
            }

        }

        function abrir_procesar_{{$key}}(){


            if(op_{{$key}}>0){
                $('#win_procesar{{$key}}').window('open');                               
            }

        }


        $('#combo_ccosto{{$key}}').combobox({
            onSelect: function(param){
                $('#dgOp_{{$key}}').datagrid({url:'orden_produccion/ops_centro_costo?ccosto='+param.id});
                $('#btn_fabricar_{{$key}}').linkbutton('disable');
            }
        });


        function procesar_orden_{{$key}}(){

            var cantidad = $("#cant_procesada_{{$key}}").val();

            $.post('orden_produccion/procesar', {control_prod: control_prod_{{$key}},cantidad: cantidad},
                function(respuesta) {
                    $('#win_procesar{{$key}}').window('close');
                    mensajeInfo(respuesta);
                    $('#dgOp_{{$key}}').datagrid('reload');
                    $('#btn_fabricar_{{$key}}').linkbutton('disable');
                }).error(
                    function(){
                        mensajeError('Error al Procesar Orden de Producción');
                }
            );
        }
        

    </script>

 