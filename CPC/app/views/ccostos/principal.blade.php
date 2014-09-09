<table id="dg_{{$key}}" title="{{$maestro->titulo}}" class="easyui-datagrid" style="width:{{$maestro->ancho}};height:{{$maestro->alto}}"
            url="{{$maestro->url}}?param=r"
            toolbar="#toolbar_{{$key}}" pagination="true"           
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
                <div class="fitem{{$key}}">
                   <label>{{$columna->titulo}}:</label>

                   @if($columna->select=="true")
                       <select class="easyui-combobox" style="width:150px" name="{{$columna->campo}}" data-options="url:'{{$columna->urlSelect}}',
                        method:'get',
                        valueField:'id',
                        textField:'nombre',
                        panelHeight:'auto',
                       ">
                        </select>

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
                   
                  $('#dg_maquina{{$key}}').datagrid({url:'{{$detalle->url}}?param=r&id='+data.id});               

                  $('#dg_cgastos{{$key}}').datagrid({url:'cgastos/CRUD?param=r&id='+data.id});
                 
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


    <div class="easyui-tabs" style="width:auto;height:300px">

        <div title="Conceptos de Gastos" style="padding:5px">

            <table class="easyui-datagrid" id="dg_cgastos{{$key}}" style="width:auto;height:250px"
                fitColumns="true" rownumbers="true" toolbar="#toolbar_cgastos{{$key}}"
                singleSelect="true" pagination="false" showFooter="true">
            <thead>
                <tr>
                    <th data-options="field:'codigo',width:50">Codigo</th>
                    <th data-options="field:'descripcion',width:120,">Descripción</th>
                    <th data-options="field:'elemento_costo',width:50">Elemento de Costo</th>
                    <th data-options="field:'comportamiento',width:50,align:'right'">Comportamiento</th>
                    <th data-options="field:'costo_real',width:50,align:'right'">Costo Real</th>
                    <th data-options="field:'costo_estimado',width:50,align:'right'">Costo Estimado</th>

                </tr>
            </thead>
            </table>
            <div id="toolbar_cgastos{{$key}}">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo{{$key}}('cgastos')">Nuevo</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar{{$key}}('cgastos')">Editar</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar{{$key}}('cgastos')">Eliminar</a>
            </div> 

            <div id="dlg_cgastos{{$key}}" class="easyui-dialog" style="width:400px;height:320px;padding:10px 20px"
                    closed="true" buttons="#dlg-buttons_cgastos{{$key}}">
                <div class="ftitle">Conceptos de Gastos</div>
                <form id="fm_cgastos{{$key}}" method="post" novalidate>
                                       

                    <div class="fitem{{$key}}">
                        <label>Codigo:</label>
                        <input name="codigo" class="easyui-validatebox" required="true">
                    </div>

                    <div class="fitem{{$key}}">
                        <label>Descripcion:</label>
                        <input name="descripcion" class="easyui-validatebox" required="true">
                    </div>

                    <div class="fitem{{$key}}">
                        <label>Elemento de Costo:</label>
                        <input class="easyui-combobox" name="elemento_costo" id="elemento_costo" data-options="url:'catalogos/elementocostoCRUD?param=r',
                                                method:'get',
                                                valueField:'id',
                                                textField:'nombre',
                                                panelHeight:'auto',
                                               
                         ">
                    </div>
                    
                    <div class="fitem{{$key}}">
                        <label>Comportamiento:</label>
                        <input class="easyui-combobox" name="comportamiento" id="comportamiento" data-options="url:'catalogos/comportamientoCRUD?param=r',
                                                method:'get',
                                                valueField:'id',
                                                textField:'nombre',
                                                panelHeight:'auto',
                         ">
                    </div>

                    <div class="fitem{{$key}}">
                        <label>Costo Real:</label>
                        <input name="costo_real" class="easyui-numberbox" data-options="min:0,precision:2" required="true">
                    </div>

                    <div class="fitem{{$key}}">
                        <label>Costo Estimado:</label>
                        <input name="costo_estimado" class="easyui-numberbox" data-options="min:0,precision:2" required="true">
                    </div>

                </form>
            </div>
            <div id="dlg-buttons_cgastos{{$key}}">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar{{$key}}('cgastos')">Guardar</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_cgastos{{$key}}').dialog('close')">Cancelar</a>
            </div>         

         </div>

        <div title="Maquinas/Estaciones" style="padding:5px">

            <table id="dg_maquina{{$key}}" class="easyui-datagrid" style="width:auto;height:250px"                    
                    toolbar="#toolbar_maquina{{$key}}" pagination="true"
                    sortName="id" sortOrder="asc"
                    rownumbers="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>

                        <th data-options="field:'codigo',width:50">Codigo</th>
                        <th data-options="field:'nombre',width:80,">Nombre</th>
                        <th data-options="field:'descripcion',width:120">Descripción</th>
                        
                    </tr>
                </thead>
            </table>
            <div id="toolbar_maquina{{$key}}">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo{{$key}}('maquina')">Nuevo</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar{{$key}}('maquina')">Editar</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar{{$key}}('maquina')">Eliminar</a>
            </div>
            
            <div id="dlg_maquina{{$key}}" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
                    closed="true" buttons="#dlg-buttons_maquina{{$key}}">
                <div class="ftitle">Maquinas/Estaciones</div>
                <form id="fm_maquina{{$key}}" method="post" novalidate>
                                       

                    <div class="fitem{{$key}}">
                        <label>Codigo:</label>
                        <input name="codigo" class="easyui-validatebox" required="true">
                    </div>

                    <div class="fitem{{$key}}">
                        <label>Nombre:</label>
                        <input name="nombre" class="easyui-validatebox" required="true">
                    </div>

                    <div class="fitem{{$key}}">
                        <label>Descripcion:</label>
                        <input name="descripcion"/>
                    </div>
                    
                </form>
            </div>
            <div id="dlg-buttons_maquina{{$key}}">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar{{$key}}('maquina')">Guardar</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_maquina{{$key}}').dialog('close')">Cancelar</a>
            </div>

        </div>        

    </div>


    <script>
     

        var url_maquina{{$key}}="maquinas/CRUD";
        var url_cgastos{{$key}}="cgastos/CRUD";

        function nuevo{{$key}}(clase){
            
            $('.easyui-combobox').combobox('reload');
            
            
            var row = $('#dg_{{$key}}').datagrid('getSelected');            
            if (row){

                $('#dlg_'+clase+'{{$key}}').dialog({
                        title:'Nuevo',
                        modal: true
                        });

                $('#dlg_'+clase+'{{$key}}').dialog('open');
                
                $('#fm_'+clase+'{{$key}}').form('clear');

                if(clase=='maquina')
                    url{{$key}} = url_maquina{{$key}}+'?param=c&id='+idMaestro;

                if(clase=='cgastos')
                    url{{$key}} = url_cgastos{{$key}}+'?param=c&id='+idMaestro;

            }

            
        }

        function editar{{$key}}(clase){
            
            $('.easyui-combobox').combobox('reload');

            var row = $('#dg_'+clase+'{{$key}}').datagrid('getSelected');
            if (row){
                
                $('#dlg_'+clase+'{{$key}}').dialog({
                    title:'Editar',
                    modal: true
                    });
                $('#dlg_'+clase+'{{$key}}').dialog('open');

                $('#fm_'+clase+'{{$key}}').form({
                            onLoadSuccess:function(){
                               $('#elemento_costo').combobox('reload');
                            }
                         }).form('load',row);
                
                if(clase=='maquina')
                    url{{$key}} = url_maquina{{$key}}+'?param=u&id='+row.id;

                if(clase=='cgastos')
                    url{{$key}} = url_cgastos{{$key}}+'?param=u&id='+row.id;
            }
        }
        function guardar{{$key}}(clase){
            
           $('#fm_'+clase+'{{$key}}').form('submit',{
                url: url{{$key}},
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
                        $('#dlg_'+clase+'{{$key}}').dialog('close');        // close the dialog
                        $('#dg_'+clase+'{{$key}}').datagrid('reload');    // reload the user data
                    }
                }
            });

        }
        function eliminar{{$key}}(clase){

            var url_elim;

            if(clase=='maquina')
                url_elim =  url_maquina{{$key}}+'?param=d';

            if(clase=='cgastos')
                url_elim =  url_cgastos{{$key}}+'?param=d';


            var row = $('#dg_'+clase+'{{$key}}').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Esta seguro de eliminar el registro Seleccionado?',function(r){
                    if (r){
                        $.post(url_elim,{id:row.id},function(result){
                            if (result.success){
                                $('#dg_'+clase+'{{$key}}').datagrid('reload');    // reload the user data
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
        #fm_maquina{{$key}}{
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
        .fitem{{$key}}{
            margin-bottom:5px;
        }
        .fitem{{$key}} label{
            display:inline-block;
            width:110px;
        }
    </style>