
 <div class="ftitle">Proceso - Centro de Costo - Tareas</div>

<input type='hidden' id='idProceso' value='{{$proceso->id}}'>

<fieldset>
 <legend>Proceso</legend>
	<table class="tablaFielset">
	<tr>
		<th>Codigo</th>		
	    <td>{{$proceso->codigo}}<td>
	    <th>Nombre:<th>
	    <td>{{$proceso->nombre}}<td>		
	</tr>
	</table>
</fieldset>
<br>

<fieldset>
<legend>Centro de Costo</legend>	
<table class="tablaFielset">
	<tr>
		<th>Centro de Costo:</th>
		<td><input class="easyui-combobox" name="ccosto" id="comboccosto_{{$key}}" data-options="url:'ccostos/combobox',
                        method:'get',
                        valueField:'id',
                        textField:'nombre',
                        panelHeight:'auto',
         "></td>
	</tr>	
</table>
</fieldset>
<br>

 <div id="toolbar_tareas">
        <a href="javascript:void(0)" id="btnAdd_{{$key}}" disabled="true" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_{{$key}}()">Nuevo</a>
        <a href="javascript:void(0)" id="btnDel_{{$key}}" disabled="true" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar_{{$key}}()">Eliminar</a>
    </div>

    <table class="easyui-datagrid" id="dgTareas" title="Tareas" style="width:auto;height:250px"
        fitColumns="true" rownumbers="true" toolbar="#toolbar_tareas"
        singleSelect="true" pagination="false">
        <thead>
            <tr>
                <th data-options="field:'nombre',width:50">Nombre</th>
                <th data-options="field:'descripcion',width:100">Descripción</th>
                <th data-options="field:'duracion',width:50">Duración en Minutos</th>             
            </tr>
        </thead>
    </table>



 <div class="ftitle"></div>

 <div align='right'>
 	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar_ccosto()">Guardar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="reloadTab('procesos')">Cancelar</a>
 </div>	


    <div id="dlg_{{$key}}" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons_{{$key}}">
        <div class="ftitle">Tarea</div>
        <form id="fm_{{$key}}" method="post" novalidate>
           
            <div class="fitem">
                <label>Nombre:</label>
                <input name="nombre" id="dlg_nombre_{{$key}}" class="easyui-validatebox" required="true">
            </div>

            <div class="fitem">
                <label>Descripción:</label>
                <input name="descripcion" id="dlg_descripcion_{{$key}}">
            </div>
           
            <div class="fitem">
                <label>Duración en Minutos:</label>
                <input name="duracion" id="dlg_duracion_{{$key}}" required="true" class="easyui-numberbox">
            </div>            
                
        </form>
    </div>
    <div id="dlg-buttons_{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="agregar_{{$key}}()">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_{{$key}}').dialog('close')">Cancelar</a>
    </div>


    <script>
     
    var id_json = 0;
    var jsonObj = [];

     $('#comboccosto_{{$key}}').combobox({
        onSelect: function(param){
           $('#btnAdd_{{$key}}').linkbutton('enable');
           $('#btnDel_{{$key}}').linkbutton('enable');
        }
    });



    function guardar_ccosto(){


        var tareasJSON = JSON.stringify(jsonObj);
        var idProceso = $("#idProceso").val();
        var ccosto = $('#comboccosto_{{$key}}').combobox('getValue');
        
        $.post('procesos/crearpccostos', {idProceso: idProceso, ccosto: ccosto, tareas: tareasJSON},
            function(respuesta) {
                reloadTab('procesos');
            }).error(
                function(){
                   alert("Error, no se pudo guardar el registro")
                }
        );

        }
  
                
        $('#dgTareas').datagrid({
            data: jsonObj
        }); 


        function nuevo_{{$key}}(){
            
            $('#dlg_{{$key}}').dialog({
                    title:'Nueva Tarea',
                    modal: true
                    });
            $('#dlg_{{$key}}').dialog('open');
            
            $('#fm_{{$key}}').form('clear');

            $("#dlg_nombre_{{$key}}").val("");
            $("#dlg_descripcion_{{$key}}").val("");
            $("#dlg_duracion_{{$key}}").val("");
            
            
        }
       

        function agregar_{{$key}}(){
           
            item = {}
            item ["id_json"] = id_json;
            item ["nombre"] = $("#dlg_nombre_{{$key}}").val();
            item ["descripcion"] = $("#dlg_descripcion_{{$key}}").val();
            item ["duracion"] = $("#dlg_duracion_{{$key}}").val();

            jsonObj.push(item);
            id_json++;

            $('#dgTareas').datagrid({data: jsonObj});

            $('#dlg_{{$key}}').dialog('close'); 

        }

        function eliminar_{{$key}}(){

            var row=$('#dgTareas').datagrid('getSelected');
    
           for(var i=0;i<jsonObj.length;i++){
                if(jsonObj[i].id_json == row.id_json){
                    jsonObj.splice(i, 1);
                    break;
                }
           }
            
            $('#dgTareas').datagrid({data: jsonObj});
               
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
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }


        .tablaFielset th{
        	display:inline-block;
            padding:5px;
        }

        .tablaFielset td{
        	padding:5px;
        }
    </style>