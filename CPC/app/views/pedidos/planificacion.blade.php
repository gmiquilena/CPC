<div class="easyui-layout" style="width:auto;height:680px;">

 
        <!-- DIV DERECHO -->
        <div data-options="region:'east',split:true,title:'',collapsible:false" style="width:700px;">

            <div class="easyui-layout" data-options="fit:true">
                
                <!-- PEDIDOS -->
                <div data-options="region:'north',split:true,border:false" style="height:350px">

                    <div id="toolbar">
                       Orden de Producción
                        <input id="op_{{$key}}" class="easyui-numberbox" class='in-disabled' disabled="true" style="text-align: right;">

                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-proceso" plain="true" onclick="generar_op()">Generar OP</a>
                    </div>

                    <table id="tg" class="easyui-treegrid" fit="true" title="Pedidos" style="auto;height:343px" toolbar="#toolbar"
                            data-options="
                                animate: true,
                                collapsible: false,
                                fitColumns: true,
                                url: '',
                                method: 'get',
                                idField: 'id',
                                treeField: 'cliente_pedido',
                                showFooter: true
                            ">
                        <thead>
                            <tr>
                                <th data-options="field:'cliente_pedido',width:100">Cliente/Pedido</th>
                                <th data-options="field:'fecha_pedido',width:100">Fecha Pedido</th>
                                <th data-options="field:'cant_pedida',width:60,align:'right',formatter:formatCantidad">Cantidad Pedida</th>
                                <th data-options="field:'cantidad',width:60,align:'right',formatter:formatCantidad" editor="{type:'numberbox',options:{required:true,min:0,precision:3}}">Cantidad OP</th>
                                
                            </tr>
                        </thead>
                    </table>
                    <script>

                        var lote;
                        var stock;
                        var producto_id;
                        
                        var editingId = undefined;
                      
                        $('#tg').treegrid({
                            onDblClickRow: function(row){
                                
                                if(row._parentId>0)
                                    $(this).treegrid('beginEdit', row.id);

                                editingId = row.id;

                                 var ed = $(this).treegrid('getEditor',
                                     {index:editingId,field:'cantidad'});

                                $(ed.target).focus().select().bind('keyup', function(e) 
                                {
                                    var code = e.keyCode || e.which;
                                    if(code == 13) { //Enter keycode
                                      //Trigger code to save row
                                                          //This executes onAfterEdit event code
                                        var t = $('#tg'); //My treegrid selector
                                        t.treegrid('endEdit', editingId);
                                        guardarTree(t);
                                    }
                                });
                                
                            },
                            onClickRow: function(row){
                                
                                $(this).treegrid('endEdit',  editingId);
                                guardarTree($(this));
                                //editingId = undefined;
                                
                            }
                        });

                        
                        function guardarTree(t){
                           
                           if (editingId != undefined){
                                
                            var cant_modif = 0;
                            var rows = t.treegrid('getChildren');
                            var parentId = 0;
                            var cant_parent = 0;


                            for(var i=0; i<rows.length; i++){

                                //si es un nodo padre
                                if(rows[i]._parentId == '0'){
                                            

                                    cant_parent = 0;
                                    parentId = rows[i].id;
                                            
                                    for(var j=0; j<rows.length; j++){

                                        if(rows[j]._parentId == parentId){
                                                    
                                            var c = parseInt(rows[j].cantidad);
                                            if (!isNaN(c)){
                                                cant_parent += c;
                                            }
                                        }
                                    }

                                    //rows[i].cantidad = cant_parent;

                                    t.treegrid('update',{
                                        id: parentId,
                                        row: {
                                            cantidad: cant_parent                                            
                                        }
                                    });

                                    continue;
                                }
                            
                                    //totalizando las cantidades
                            var p = parseInt(rows[i].cantidad);
                            if (!isNaN(p)){
                                cant_modif += p;
                            }
                        
                        }

                        //modificando el footer
                        var frow = t.treegrid('getFooterRows')[0];
                        frow.cantidad = cant_modif;
                        t.treegrid('reloadFooter');

                        
                        //actializar la mini ficha de materiales
                        $('#dgMateriales_{{$key}}').datagrid({url:'pedidos/materiales_producto?idProducto='+producto_id+'&cant_pedida='+cant_modif});

                        var aux_cant=stock;
                        var fabricar=0;
                        
                        while(aux_cant<cant_modif){

                            aux_cant+=lote;
                            fabricar+=lote;

                        }

                        $('#op_{{$key}}').val(formatCantidad(fabricar,null));


                        editingId = undefined;

                        }
                            
                    }

                    function generar_op(){

                        var rows = $('#dgMateriales_{{$key}}').datagrid('getRows');

                        for (i=0;i<rows.length;i++){

                            if(rows[i].cant_requerida>rows[i].stock){
                                mensajeAlerta("No cuenta con los Materiales suficientes para fabricar la Orden de Producción");
                                return;
                            }
                        }

                        var cantidad_op=$("#op_{{$key}}").val();
                        var jsonPedidos = $('#tg').treegrid('getChildren');

                        if(cantidad_op==0){
                            mensajeAlerta("La cantidad a Generar es 0");
                            return;
                        }


                        jsonPedidos = JSON.stringify(jsonPedidos);
                        

                        $.post('orden_produccion/guardar_op_planificacion', {producto_id: producto_id, cantidad_op: cantidad_op,
                            pedidos: jsonPedidos},
                            function(respuesta) {
                                 mensajeInfo(respuesta);
                                 reloadTab('pedidos/planificacion');
                        }).error(
                            function(){
                                 mensajeError('Error al Crear Orden de Producción');
                            }
                        );
                        
                        
                    }
                 
                    </script>


                </div>
                

                <!-- MATERIALES -->
                <div data-options="region:'center',border:false">
                     <table id="dgMateriales_{{$key}}" class="easyui-datagrid" title="Materiales" style="width:auto;height:300px"
                        data-options="singleSelect:false" fitColumns="true" fit="true">
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
            </div>

        </div>

        <!-- DIV CENTRAL -->
        <div data-options="region:'center'">
            
            <div class="easyui-layout" data-options="fit:true">

                <!-- ALERTAS -->
                <div data-options="region:'north',split:true,title:'Alertas',collapsible:false" style="height:100px"></div>
               
                <div data-options="region:'center',border:false,title:'Productos',iconCls:'icon-producto'">
                    <table id="dgResumenPedidos_{{$key}}" class="easyui-datagrid" style="width:650px;height:auto"
                            fit="true" border="false" url="pedidos/resumen_pedidos"
                            singleSelect="true" fitColumns="true" fit="true"
                            idField="itemid" >
                        <thead>
                            <tr>
                                <th field="codigo" width="120">Codigo Prod</th>
                                <th field="nombre" width="150">Producto</th>
                                <th data-options="field:'cant_inventario',width:80,align:'right',formatter:formatCantidad">Stock</th>
                                <th field="cant_pedida" width="120" align="right">Total Pedidos</th>
                                <th data-options="field:'lote',width:80,align:'right',formatter:formatCantidad">Lote</th>
                                <th data-options="field:'fabricar',width:80,align:'right',formatter:formatCantidad">Fabricar</th>
                            </tr>
                        </thead>
                    </table>

                    <script>



                        $('#dgResumenPedidos_{{$key}}').datagrid({
                            onClickRow: function(index,data){
                               $('#tg').treegrid({url:'pedidos/tree_pedido_producto?idProducto='+data.id});

                               $('#dgMateriales_{{$key}}').datagrid({url:'pedidos/materiales_producto?idProducto='+data.id+'&cant_pedida='+data.cant_pedida});

                               $('#op_{{$key}}').val(formatCantidad(data.fabricar,null));

                               producto_id=data.id;
                               lote = parseInt(data.lote);
                               stock = parseInt(data.cant_inventario);

                            }


                        });
                    </script>

                </div>
            </div>


        </div>

    </div>

    <script>

            function formatCantStock(val,row){

                var stock = Number(val);
                var cant_requerida = Number(row.cant_requerida);

                val=formatCantidad(val,null);

                if (stock < cant_requerida){
                    return '<span style="color:red;">'+val+'</span>';
                } else {
                    return val;
                }
            }    

    </script>