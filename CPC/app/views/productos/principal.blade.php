<table id="dg_{{$key}}" title="Productos" class="easyui-datagrid" style="width:auto;height:300px"
            url="productos/listar_productos"
            toolbar="#toolbar_{{$key}}" pagination="true"
             sortName="codigo" sortOrder="asc"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
            
                <th data-options="field:'codigo',width:50" sortable="true">Codigo</th>
                <th data-options="field:'nombre',width:100" sortable="true">Nombre</th>
                <th data-options="field:'unidad_medida',width:50">Unidad de Medida</th> 
                <th data-options="field:'stock_min',width:50">Stock Min.</th>
                <th data-options="field:'stock_max',width:50">Stock Max.</th>                

                            
            </tr>
        </thead>
    </table>
    <div id="toolbar_{{$key}}">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="reloadTab('productos/agregar')">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar_{{$key}}()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminarProducto_{{$key}}()">Eliminar</a>
    </div>


     <div class="easyui-panel" id="ficha_{{$key}}" title="Ficha de Producto" collapsed="true" collapsible="true" style="width:auto">
        <div style="padding:10px 10px 10px 10px">
            <table>
                <tr>
                    <td>Proceso:</td>
                    <td>
                        <input name="procesos" class="in-disabled" disabled="true" id="proceso_{{$key}}">
                    </td>
                    <td>Lote:</td>
                    <td><input  class="easyui-numberbox in-disabled in-numerico" disabled="true" type="text" name="lote" id="lote_{{$key}}" data-options="required:true"/></td>
                
                    <td>Costo Total:</td>
                    <td><input  class="easyui-numberbox in-numerico in-disabled" disabled="true" type="text" id="costo_total_{{$key}}" name="costo_total"/></td>
                    <td>Costo por Unidad:</td>
                    <td><input  class="easyui-numberbox in-numerico in-disabled" disabled="true" type="text" id="costo_unidad_{{$key}}" name="costo_unidad"/></td>
                </tr>    
            </table>

        </div>
    
    <div class="easyui-tabs" style="width:auto;height:300px">

        <div title="Materiales" style="padding:5px">

            <br>    
           
            <table class="easyui-datagrid" id="dgMateriales_{{$key}}" style="width:auto;height:240px"
                fitColumns="true" rownumbers="true"
                singleSelect="true" pagination="false" showFooter="true">
            <thead>
                <tr>
                    <th data-options="field:'codigo',width:50">Codigo</th>
                    <th data-options="field:'nombre',width:120,">Descripción</th>
                    <th data-options="field:'ccosto_consumo',width:50">C. Costo de Consumo</th>
                    <th data-options="field:'unidad_medida',width:50">Unidad</th>
                    <th data-options="field:'cantidad',width:50,align:'right'">Cantidad</th>
                    <th data-options="field:'costo_unitario',width:50,align:'right'">Costo Unitario</th>
                    <th data-options="field:'costo_total',width:50,align:'right',formatter:formatCosto">Costo Total</th>

                </tr>
            </thead>
            </table>
                                    
        </div> 

        <div title="Gastos de Mano de Obra" style="padding:5px">
        <br>    
                
        <table id="tgManoObra_{{$key}}" class="easyui-treegrid" style="width:auto;height:240px" showFooter="true"
            data-options="
                animate: true,
                fitColumns: true,
                method: 'get',
                idField: 'id',
                treeField: 'nombre'
            ">
            <thead>
                <tr>
                    <th data-options="field:'nombre',width:50">Nombre</th>
                    <th data-options="field:'descripcion',width:80,">Descripción</th>
                    <th data-options="field:'duracion',width:50,align:'right'">Duración de Tarea en Minutos</th>
                    <th data-options="field:'costo_unitario',width:50,align:'right'">Costo Unitario</th>
                    <th data-options="field:'costo_total',width:50,align:'right'">Costo Total</th>


                </tr>
            </thead>
        </table>

            
        </div>

        <div title="Gastos de Fabricación" style="padding:5px">
        <br>
        <table id="tgFabricacion_{{$key}}" class="easyui-treegrid" style="width:auto;height:240px" showFooter="true"
            data-options="
                animate: true,
                fitColumns: true,
                method: 'get',
                idField: 'id',
                treeField: 'nombre'
            ">
            <thead>
                <tr>
                    <th data-options="field:'nombre',width:50">Nombre</th>
                    <th data-options="field:'descripcion',width:80,">Descripción</th>
                    <th data-options="field:'duracion',width:50,align:'right'">Duración de Tarea en Minutos</th>
                    <th data-options="field:'costo_unitario',width:50,align:'right'">Costo Unitario</th>
                    <th data-options="field:'costo_total',width:50,align:'right'">Costo Total</th>                
                </tr>
            </thead>
        </table>

            
        </div>

    </div>

</div> <!--fin de la ficha de producto -->

<script>
    
    $('#dg_{{$key}}').datagrid({
        onClickRow: function(index,data){
                   
                 
            $.getJSON('productos/ficha_producto?id='+data.id,{format: "json"},function( data ) {
                    
                    
                    if(data['ficha']){

                        $("#proceso_{{$key}}").val("");
                        $("#lote_{{$key}}").val("");                       
                        $("#costo_total_{{$key}}").val("");
                        $("#costo_unidad_{{$key}}").val("");

                        $('#dgMateriales_{{$key}}').datagrid('loadData', {"total":0,"rows":[],"footer":[]});
                        $('#tgManoObra_{{$key}}').treegrid('loadData', {"total":0,"rows":[],"footer":[]});
                        $('#tgFabricacion_{{$key}}').treegrid('loadData', {"total":0,"rows":[],"footer":[]});

                      
                        return;
                    }


                    $("#proceso_{{$key}}").val(data['proceso']);
                    $("#lote_{{$key}}").val(data['lote']);

                    $('#dgMateriales_{{$key}}').datagrid({data: data['materiales']});

                    var costo_total = data['materiales']['footer'][0]['costo_total'];
                    var lote = data['lote'];

                    $('#tgManoObra_{{$key}}').treegrid({url:'procesos/tree_ccostos_mo?id='+data['proceso_id']});
                    $('#tgFabricacion_{{$key}}').treegrid({url:'procesos/tree_ccostos_gf?id='+data['proceso_id']});
                    
                    $.getJSON('procesos/costo_proceso?id='+data['proceso_id'],{format: "json"},function( data ) {
                    
                        var costo_mo = data['costo_mo'];
                        var costo_gf = data['costo_gf'];
                        
                        costo_total+=costo_mo+costo_gf;

                        $("#costo_total_{{$key}}").val(redondeo(costo_total,2));
                        $("#costo_unidad_{{$key}}").val(redondeo(costo_total/lote,2));
                        
                    //ActualizarCostoUnidad_{{$key}}();                    

                    });

            });
           
        }
    });
    

    function eliminarProducto_{{$key}}(){

        var row = $('#dg_{{$key}}').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Esta seguro de eliminar el Producto Seleccionado?',function(r){
                    if (r){
                        $.post('productos/eliminar_producto?param=d',{id:row.id},function(respuesta) {
                                $('#dg_{{$key}}').datagrid('reload');                                
                        }).error(
                            function(){
                                 mensajeError('Error, no se puede Borrar el Producto');
                            }
                        );
                    }
                });
            }
    }

</script>