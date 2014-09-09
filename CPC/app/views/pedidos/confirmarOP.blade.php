<div class="easyui-panel" title="Orden de Produccion" style="width:700px;height:200px;padding:10px;">
       
       <table id="dgMateriales_{{$key}}" class="easyui-datagrid" title="Materiales" style="width:auto;height:300px"
            data-options="singleSelect:false" fitColumns="true">
            <thead>
                <tr>
                    <th data-options="field:'codigo',width:90">Codigo</th>
                    <th data-options="field:'nombre',width:150">Descripcion</th>
                    <th data-options="field:'unidad_medida',width:50">Unidad</th>
                    <th data-options="field:'cant_requerida',width:100,align:'right',formatter:formatCantidad">Cant. Requerida</th>
                    <th data-options="field:'stock',width:80,align:'right',formatter:formatCantStock">Cant. Stock</th>                            
                </tr>
            </thead>
        </table> 



</div>