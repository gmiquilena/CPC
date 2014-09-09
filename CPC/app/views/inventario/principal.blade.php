<table id="dgInv_{{$key}}" title="Inventario" class="easyui-datagrid" style="width:auto;height:380px"
            url="catalogos/inventarioCRUD?param=r&tipo_inv=2"
            toolbar="#toolbar_{{$key}}" pagination="true"
             sortName="id" sortOrder="asc"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
            
                <th data-options="field:'codigo',width:50" sortable="true">Codigo</th>
                <th data-options="field:'nombre',width:100">Producto</th>
                <th data-options="field:'unidad_medida',width:50">Unidad Medida</th>
                <th data-options="field:'cantidad',width:50,align:'right'" formatter="formatCantidad">Existencia</th>
                <th data-options="field:'cant_comprometida',width:50,align:'right'" formatter="formatCantidad">Comprometida</th>
                <th data-options="field:'cant_disponible',width:50,align:'right'" formatter="formatCantidad">Disponible</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar_{{$key}}">
       <table>
        <td>
            Tipo de Inventario:
        </td>
        <td>
            <input class="easyui-combobox" style="width:200px" value="2" id="combo_tipo_inv_{{$key}}" data-options="url:'catalogos/tipo_inventarioCRUD?param=r',
                                                method:'get',
                                                valueField:'id',
                                                textField:'nombre',
                                                panelHeight:'auto',
                         "> 
        </td>
       </table>

    </div>

    <script>

        $('#combo_tipo_inv_{{$key}}').combobox({
            onSelect: function(param){
                $('#dgInv_{{$key}}').datagrid({url:'catalogos/inventarioCRUD?param=r&tipo_inv='+param.id});
            }
        });

    </script>