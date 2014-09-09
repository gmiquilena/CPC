<table id="dg_{{$key}}" title="{{$maestro->titulo}}" class="easyui-datagrid" style="width:{{$maestro->ancho}};height:{{$maestro->alto}}"
            url="{{$maestro->url}}?param=r"
            toolbar="#toolbar_{{$key}}" pagination="true"
            sortName="id" sortOrder="asc"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
   
                <th data-options="field:'codigo',width:50" sortable="true">Codigo</th>
                <th data-options="field:'nombre',width:80" sortable="true">Nombre</th>
                <th data-options="field:'descripcion',width:100">Descripción</th> 
                <th data-options="field:'tipo_producto',width:80">Tipo de Producto</th>
                <th data-options="field:'sub_tipo_producto',width:80">Sub-Tipo Producto</th> 
                
            </tr>
        </thead>
    </table>
    <div id="toolbar_{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_{{$key}}()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar_{{$key}}()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar_{{$key}}()">Eliminar</a>
    </div>
    
    <div id="dlg_{{$key}}" class="easyui-dialog" style="width:450px;height:300px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons_{{$key}}">
        <div class="ftitle">{{$maestro->tituloForm}}</div>
        <form id="fm_{{$key}}" method="post" novalidate>
           
                <table>
                    <tr>
                        <td>Codigo:</td>
                        <td><input name="codigo" class="easyui-validatebox" required="true"></td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><input name="nombre" class="easyui-validatebox" required="true"></td>
                    </tr>
                    <tr>
                        <td>Descripción:</td>
                        <td><input name="descripcion"></td>
                    </tr>
                   
                    <tr>
                        <td>Tipo de Producto:</td>                    
                        <td><select id="tipo_producto_{{$key}}" required="true" name="tipo_producto" class="easyui-combogrid" style="width:150px" data-options="
                                panelWidth: 500,
                                idField: 'id',
                                textField: 'codigo',
                                url: 'catalogos/tipo_productoCRUD?param=r',
                                method: 'get',
                                columns: [[
                                    {field:'codigo',title:'Codigo',width:80},
                                    {field:'nombre',title:'nombre',width:120},                                
                                ]],
                                fitColumns: true
                                ">
                        </select></td>
                    </tr>
                    
                    <script>
                        $('#tipo_producto_{{$key}}').combogrid({
                            onSelect: function(){
                              
                             var r = $(this).datagrid('getSelected');
                             $('#sub_tipo_producto_{{$key}}').combogrid({url:'catalogos/sub_tipo_productoCRUD?param=r&id='+r.id});

                            }
                        });
                                              
                    </script>

                    <tr>
                        <td>Sub Tipo de Producto:</td>
                        <td><select id="sub_tipo_producto_{{$key}}" required="true" name="sub_tipo_producto" class="easyui-combogrid" style="width:150px" data-options="
                                panelWidth: 500,
                                idField: 'id',
                                textField: 'codigo',
                                method: 'get',
                                columns: [[
                                    {field:'codigo',title:'Codigo',width:80},
                                    {field:'nombre',title:'nombre',width:120},                                
                                ]],
                                fitColumns: true
                                ">
                        </select></td>
                    </tr>
                </table>
          
        </form>
    </div>
    <div id="dlg-buttons_{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar_{{$key}}()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_{{$key}}').dialog('close')">Cancelar</a>
    </div>
   
    <br>

    <!----------------------------------------- TABLA DETALLE ---------------------------------------->




<div id="toolbar_tree_{{$key}}">
    <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-add" onclick="agregarCcostoTarea_{{$key}}();">Agregar</a>
    <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="">Editar</a>-->
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminarCcostoTarea_{{$key}}()">Eliminar</a>
</div>

<table id="tgTree_{{$key}}" class="easyui-treegrid" toolbar="#toolbar_tree_{{$key}}" showFooter="true" title="Centro de Costo / Tareas" style="width:auto;height:250px"
            data-options="
                animate: true,
                fitColumns: true,
                url: 'procesos/treeccostos',
                method: 'get',
                idField: 'id',
                treeField: 'nombre'
            ">
        <thead>
            <tr>
                <th data-options="field:'nombre',width:50">Nombre</th>
                <th data-options="field:'descripcion',width:80,">Descripción</th>
                <th data-options="field:'duracion',width:50">Duración de Tarea en Minutos</th>                
            </tr>
        </thead>
    </table>

 <script type="text/javascript">
        
        var idMaestro;

        $('#dg_{{$key}}').datagrid({
                onClickRow: function(index,data){                   
                  $('#tgTree_{{$key}}').treegrid({url:'procesos/treeccostos?id='+data.id});
                  $('#tgTree_{{$key}}').treegrid('reload');
                  idMaestro=data.id;
                }
            });
      

        function agregarCcostoTarea_{{$key}}(){
            var row = $('#dg_{{$key}}').datagrid('getSelected');
            if (row){
                reloadTab('procesos/addccostos?id='+idMaestro);
            }
        }

        function eliminarCcostoTarea_{{$key}}(){
            
            var row = $('#tgTree_{{$key}}').treegrid('getSelected');
            if (row._parentId==0){
                $.messager.confirm('Confirmar','¿Esta seguro de eliminar el registro Seleccionado?',function(r){
                    if (r){
                        $.post('procesos/eliminarpccostos',{id:row.id},function(result){
                            if (result.success){
                                $('#tgTree_{{$key}}').treegrid('reload');    // reload the user data
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







        var url_{{$key}};
        function nuevo_{{$key}}(){
            
            $('.easyui-combobox').combobox('reload');
            
            $('#dlg_{{$key}}').dialog({
                    title:'Nuevo {{$maestro->tituloForm}}',
                    modal: true
                    });
            $('#dlg_{{$key}}').dialog('open');
            
            $('#fm_{{$key}}').form('clear');
            url_{{$key}} = '{{$maestro->url}}?param=c';
        }
        function editar_{{$key}}(){
            
            $('.easyui-combobox').combobox('reload');

            var row = $('#dg_{{$key}}').datagrid('getSelected');
            if (row){
                
                $('#dlg_{{$key}}').dialog({
                    title:'Editar {{$maestro->tituloForm}}',
                    modal: true
                    });
                $('#dlg_{{$key}}').dialog('open');

                $('#fm_{{$key}}').form('load',row);
                url_{{$key}} = '{{$maestro->url}}?param=u&id='+row.id;
            }
        }
        function guardar_{{$key}}(){
            $('#fm_{{$key}}').form('submit',{
                url: url_{{$key}},
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg_{{$key}}').dialog('close');        // close the dialog
                        $('#dg_{{$key}}').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function eliminar_{{$key}}(){
            var row = $('#dg_{{$key}}').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Esta seguro de eliminar el registro Seleccionado?',function(r){
                    if (r){
                        $.post('{{$maestro->url}}?param=d',{id:row.id},function(result){
                            if (result.success){
                                $('#dg_{{$key}}').datagrid('reload');    // reload the user data
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

    <style type="text/css">
        #fm_d{{$key}}{
            margin:0;
            padding:10px 30px;            
        }
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
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
    </style>