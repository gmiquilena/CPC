<table id="dgOp_{{$key}}" title="Ordenes de Producción" class="easyui-datagrid" style="width:auto;height:300px"
            url="orden_produccion/CRUD?param=r"
            toolbar="#toolbar_{{$key}}" pagination="true"
             sortName="id" sortOrder="asc"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
            
                <th data-options="field:'id',width:50" sortable="true" formatter="formatOp">Nº de Orden</th>
                <th data-options="field:'codigo',width:50">Codigo Prod.</th> 
                <th data-options="field:'producto',width:100">Producto</th>
                <th data-options="field:'estado',width:50">Estado</th>
                <th data-options="field:'cantidad_ped',width:50,align:'right'" formatter="formatCantidad">Cant. a Fabricar</th>
                <th data-options="field:'cantidad_term',width:50,align:'right'" formatter="formatCantidad">Cant. Terminada</th>
                            
            </tr>
        </thead>
    </table>
    <div id="toolbar_{{$key}}">
        <a href="javascript:void(0)" id="btn_fabricar_{{$key}}" disabled='true' class="easyui-linkbutton" iconCls="icon-proceso" plain="true" onclick="procesar_orden_{{$key}}()">Fabricar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ordenes" plain="true" onclick="detalle_orden_{{$key}}()">Ver</a>
    </div>

    <div id="win_{{$key}}" class="easyui-window" title="Orden de Producción" data-options="modal:true,closed:true,iconCls:'icon-ordenes'"
             style="width:780px;height:600px">
        
    </div>

<!--
    <div id="win_descartes_{{$key}}" class="easyui-window" title="Orden de Producción" data-options="modal:true,closed:false,iconCls:'icon-ordenes'" style="width:800px;height:500px">

         <div class="tabla-reporte">
            <table>
                <thead>
                    <th>Cant. a Fabricar</th>
                    <th>Cant. Terminada </th>
                    <th>Descartes</th>                    
                </thead>

            <tbody>             
                <tr>
                    <td style="text-align:right">
                    10
                    </td>
                    <td style="text-align:right">
                    8
                    </td>
                    <td style="text-align:right">
                    2
                    </td>           
                </tr>
             
            </tbody>
            </table>
            </div>

         <table align="center" class="tablaForm">

            <tr>
                <td>Centro Costo:</td>
                <td><input id="cant_procesada_{{$key}}" class="easyui-numberbox in-numerico" data-options="min:0,precision:3"></td>
                <td>Motivo Descarte:</td>
                <td><input id="cant_procesada_{{$key}}" class="easyui-numberbox in-numerico" data-options="min:0,precision:3"></td>
                <td>Cantidad:</td>
                <td><input id="cant_procesada_{{$key}}" class="easyui-numberbox in-numerico" data-options="min:0,precision:3"></td>
            </tr>

            <tr>
                <td>Nota:</td>
                <td colspan="5"></td>
            </tr>

        </table>
        
    </div>

-->

    <script>

        var op_{{$key}} = -1;
        

        $('#dgOp_{{$key}}').datagrid({
                            onClickRow: function(index,data){
                                op_{{$key}} = data.id;
                                


                                if(data.estado=='NUEVA')
                                   $('#btn_fabricar_{{$key}}').linkbutton('enable');
                                else
                                   $('#btn_fabricar_{{$key}}').linkbutton('disable');   
                          }
                        });

        function detalle_orden_{{$key}}(){


            if(op_{{$key}}>0){
                $('#win_{{$key}}').window('open');
                $('#win_{{$key}}').window('refresh', 'orden_produccion/reporte?op='+op_{{$key}});
            }

        }

        function procesar_orden_{{$key}}(){

            if(op_{{$key}}>0){
                $.messager.confirm('Confirmar', '¿Desea Iniciar la Orden de Producción '+formatOp(op_{{$key}},null)+'?', function(r){
                    if (r){
                        
                        $.post('orden_produccion/fabricar', {op: op_{{$key}}},
                            function(respuesta) {
                                mensajeInfo(respuesta);
                                $('#dgOp_{{$key}}').datagrid('reload');
                                $('#btn_fabricar_{{$key}}').linkbutton('disable');
                        }).error(
                            function(){
                                 mensajeError('Error al Inicio Orden de Producción');
                            }
                        );
                    }
                 });
            }

        }


    </script>
