<table id="dgPedidos_{{$key}}" title="Pedidos" class="easyui-datagrid" style="width:auto;height:300px"
            url="pedidos/CRUD?param=r"
            toolbar="#toolbar_{{$key}}" pagination="true"
             sortName="id" sortOrder="asc"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
            
                <th data-options="field:'num_pedido',width:50" sortable="true" formatter="formatCodigo">Nº de Pedido</th>
                <th data-options="field:'cliente',width:100" sortable="true">Cliente</th>
                <th data-options="field:'fecha_pedido',width:50">Fecha del Pedido</th> 
                <th data-options="field:'estado',width:50">Estado</th>
                            
            </tr>
        </thead>
    </table>
    <div id="toolbar_{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="reloadTab('pedidos/agregar')">Nuevo</a>
        <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar_{{$key}}()">Editar</a>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-no" plain="true" onclick="anular_{{$key}}()">Anular</a>
    </div>

    
   
    <script type="text/javascript">
    
    var idMaestro;

        $('#dgPedidos_{{$key}}').datagrid({
                onClickRow: function(index,data){
                   
                  $('#dgItems_{{$key}}').datagrid({url:'pedidos/itemsCRUD?param=r&id='+data.id});

                  $('#btnFabricar_{{$key}}').linkbutton('disable'); 
                  $('#btnAnular_{{$key}}').linkbutton('disable'); 
                 
                  idMaestro=data.id;
                }
            });
    
        
        function anular_{{$key}}(){
            var row = $('#dgPedidos_{{$key}}').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Esta seguro de anular el Pedido?',function(r){
                    if (r){
                        $.post('pedidos/CRUD?param=d',{id:row.id},function(result){
                            if (result.success){
                                $('#dgPedidos_{{$key}}').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
    </script>


    <br>

    <!----------------------------------------- TABLA DETALLE ---------------------------------------->

    <table id="dgItems_{{$key}}" title="Items" class="easyui-datagrid" style="width:auto;height:300px"
            toolbar="#toolbar_dgItems{{$key}}"             
            rownumbers="true" fitColumns="true"
            singleSelect="true">
        <thead>
            
            
                <th data-options="field:'cod_producto',width:50">Cod Producto</th>
                <th data-options="field:'producto',width:100" >Producto</th>
                <th data-options="field:'cantidad',width:50" align="right">Cantidad</th> 
                <th data-options="field:'estado',width:50">Estado</th>
                <th data-options="field:'nota',width:100">Nota</th>
                            
            
        </thead>
    </table>


    <div id="toolbar_dgItems{{$key}}">
      <!--  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="reloadTab('pedidos/agregar')">Agregar</a>        -->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-no" plain="true" id="btnAnular_{{$key}}" disabled='true' onclick="anular_{{$key}}()">Anular</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnFabricar_{{$key}}" iconCls="icon-proceso" disabled='true' plain="true" onclick="fabricar_{{$key}}()">Fabricar</a>
    </div>

    <script>

    var idItem=0;

    $('#dgItems_{{$key}}').datagrid({
                onClickRow: function(index,data){

                if(data.estado=="NUEVO"){
                    $('#btnFabricar_{{$key}}').linkbutton('enable'); 
                    $('#btnAnular_{{$key}}').linkbutton('enable'); 
                }
                else
                {
                    $('#btnFabricar_{{$key}}').linkbutton('disable'); 
                    $('#btnAnular_{{$key}}').linkbutton('disable'); 
                }
                  

                  idItem=data.id;
                }
            });

    
    function fabricar_{{$key}}(){
        reloadTab('orden_produccion/agregar?idItem='+idItem);
    }

    </script>    



    <style type="text/css">
        

        #fm_{{$key}}{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{{$key}}{
            margin-bottom:5px;
        }
        .fitem{{$key}} label{
            display:inline-block;
            width:110px;
        }
    </style>