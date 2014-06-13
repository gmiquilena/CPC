<table id="dg_{{$key}}" title="{{$maestro->titulo}}" class="easyui-datagrid" style="width:{{$maestro->ancho}};height:{{$maestro->alto}}"
            url="{{$maestro->url}}?param=r"
            toolbar="#toolbar_{{$key}}" pagination="true"
            sortName="id" sortOrder="asc"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                @foreach($colMaestro as $columna)
     
                 {{"<th field='$columna->campo' width='$columna->ancho'>".$columna->titulo."</th>";}}

                @endforeach 
            </tr>
        </thead>
    </table>
    <div id="toolbar_{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_{{$key}}()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar_{{$key}}()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar_{{$key}}()">Eliminar</a>
    </div>
    
    <div id="dlg_{{$key}}" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons_{{$key}}">
        <div class="ftitle">{{$maestro->tituloForm}}</div>
        <form id="fm_{{$key}}" method="post" novalidate>
           
            @foreach($colMaestro as $columna)            
                @if($columna->editable=="true")
                <div class="fitem">
                   <label>{{$columna->titulo}}:</label>

                   @if($columna->select=="true")
                       <input class="easyui-combobox" name="{{$columna->campo}}" data-options="url:'{{$columna->urlSelect}}',
                        method:'get',
                        valueField:'id',
                        textField:'nombre',
                        panelHeight:'auto',
                       ">

                   @else
                        <input name="{{$columna->campo}}" class="{{$columna->class}}" 
                          required="{{$columna->required}}" validType="{{$columna->validType}}">
                   @endif

                </div>
                @endif
            @endforeach
        </form>
    </div>
    <div id="dlg-buttons_{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar_{{$key}}()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_{{$key}}').dialog('close')">Cancelar</a>
    </div>
    <script type="text/javascript">
    
    var idMaestro;

        $('#dg_{{$key}}').datagrid({
                onClickRow: function(index,data){
                   
                  $('#dg_d{{$key}}').datagrid({url:'{{$detalle->url}}?param=r&id='+data.id});
                  $('#dg_d{{$key}}').datagrid('reload');
                  idMaestro=data.id;
                }
            });
     

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


    <br>

    <!----------------------------------------- TABLA DETALLE ---------------------------------------->


    <table id="dg_d{{$key}}" title="{{$detalle->titulo}}" class="easyui-datagrid" style="width:{{$detalle->ancho}};height:{{$detalle->alto}}"
            
            toolbar="#toolbar_d{{$key}}" pagination="true"
            sortName="id" sortOrder="asc"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                @foreach($colDetalle as $columna)
     
                 {{"<th field='$columna->campo' width='$columna->ancho'>".$columna->titulo."</th>";}}

                @endforeach 
            </tr>
        </thead>
    </table>
    <div id="toolbar_d{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_d{{$key}}()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar_d{{$key}}()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar_d{{$key}}()">Eliminar</a>
    </div>
    
    <div id="dlg_d{{$key}}" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons_d{{$key}}">
        <div class="ftitle">{{$detalle->tituloForm}}</div>
        <form id="fm_d{{$key}}" method="post" novalidate>
           
            @foreach($colDetalle as $columna)            
                @if($columna->editable=="true")
                <div class="fitem">
                   <label>{{$columna->titulo}}:</label>

                   @if($columna->select=="true")
                       <input class="easyui-combobox" name="{{$columna->campo}}" data-options="url:'{{$columna->urlSelect}}',
                        method:'get',
                        valueField:'id',
                        textField:'nombre',
                        panelHeight:'auto',
                       ">

                   @else
                        <input name="{{$columna->campo}}" class="{{$columna->class}}" 
                          required="{{$columna->required}}" validType="{{$columna->validType}}">
                   @endif

                </div>
                @endif
            @endforeach
        </form>
    </div>
    <div id="dlg-buttons_d{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar_d{{$key}}()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_d{{$key}}').dialog('close')">Cancelar</a>
    </div>
    <script type="text/javascript">
     

        var url_d{{$key}};
        function nuevo_d{{$key}}(){
            
            $('.easyui-combobox').combobox('reload');
            
            var row = $('#dg_{{$key}}').datagrid('getSelected');
            if (row){

                $('#dlg_d{{$key}}').dialog({
                        title:'Nuevo {{$detalle->tituloForm}}',
                        modal: true
                        });
                $('#dlg_d{{$key}}').dialog('open');
                
                $('#fm_d{{$key}}').form('clear');
                url_d{{$key}} = '{{$detalle->url}}?param=c&id='+idMaestro;
            }
        }
        function editar_d{{$key}}(){
            
            $('.easyui-combobox').combobox('reload');

            var row = $('#dg_d{{$key}}').datagrid('getSelected');
            if (row){
                
                $('#dlg_d{{$key}}').dialog({
                    title:'Editar {{$detalle->tituloForm}}',
                    modal: true
                    });
                $('#dlg_d{{$key}}').dialog('open');

                $('#fm_d{{$key}}').form('load',row);
                url_d{{$key}} = '{{$detalle->url}}?param=u&id='+row.id;
            }
        }
        function guardar_d{{$key}}(){
            $('#fm_d{{$key}}').form('submit',{
                url: url_d{{$key}},
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
                        $('#dlg_d{{$key}}').dialog('close');        // close the dialog
                        $('#dg_d{{$key}}').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function eliminar_d{{$key}}(){
            var row = $('#dg_d{{$key}}').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Esta seguro de eliminar el registro Seleccionado?',function(r){
                    if (r){
                        $.post('{{$detalle->url}}?param=d',{id:row.id},function(result){
                            if (result.success){
                                $('#dg_d{{$key}}').datagrid('reload');    // reload the user data
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