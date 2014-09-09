 <div class="easyui-panel" title="Nuevo Pedido" style="width:auto">
        <div style="padding:2px">
            <table cellpadding="5">
                <tr>

                    <td>Cliente:</td>
                    <td>
                       <select class="easyui-combobox" id="cliente_{{$key}}"  style="width:200px;" name="cliente" data-options="url:'catalogos/clienteCRUD?param=combo',
                        method:'get',
                        valueField:'id',
                        textField:'nombre',
                        panelHeight:'auto',
                       ">
                        </select>
                    </td>

                    <td>Fecha del Pedido:</td>
                    <td>
                         <input class="easyui-datebox" id="fecha_pedido_{{$key}}" name="fecha_pedido"></input>
                    </td>
                 </tr>   
            </table>                    

         </div>          
    </div>
    <br />
   
         <div class="easyui-panel" title="Items" style="width:auto">
          
            <table>
                 <tr>
                    <td>Productos:</td>
                    <td>
                        <select id="items_{{$key}}" class="easyui-combogrid" style="width:250px" data-options="
                                panelWidth: 500,
                                idField: 'id',
                                textField: 'nombre',
                                url: 'productos/listar_productos?tipo=PT',
                                method: 'get',
                                columns: [[
                                    {field:'codigo',title:'Codigo',width:80},
                                    {field:'nombre',title:'Descripcion',width:150},
                                    {field:'unidad_medida',title:'Unidad',width:80}                                
                                ]],
                                fitColumns: true
                                ">
                        </select>
                    </td>
                    <td>Cantidad:</td>
                    <td>
                        <input name="cantidad" id="cantidad_{{$key}}" class="easyui-numberbox" data-options="min:0,precision:3">
                    </td>
                    <td>
                        <a href="javascript:void(0)" id="btnAdd_{{$key}}" disabled="true" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="agregar_material_{{$key}}();"></a>
                    </td>
                    <td>
                        <a href="javascript:void(0)" id="btnDel" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar_material_{{$key}}();"></a>
                    </td>
                </tr>                
                <tr>
                    <td>
                        Nota:
                    </td>                   
                    <td colspan='3'>
                         <textarea id="nota_{{$key}}" style="width: 100%;"></textarea>
                    </td>
                </tr>    
            </table>
            <br>

            <table class="easyui-datagrid" id="dgProductos_{{$key}}" style="width:auto;height:240px"
                fitColumns="true" rownumbers="true"
                singleSelect="true" pagination="false" showFooter="false">
            <thead>
                <tr>
                    <th data-options="field:'codigo',width:50">Codigo</th>
                    <th data-options="field:'nombre',width:120,">Descripción</th>
                    <th data-options="field:'nota',width:50">Nota</th>
                    <th data-options="field:'unidad_medida',width:50">Unidad</th>
                    <th data-options="field:'cantidad',width:50,align:'right'">Cantidad</th>
                </tr>
            </thead>
            </table>
                                    
        </div> 


    <div style="text-align:right;padding:5px; width:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar_producto_{{$key}}()">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"onclick="reloadTab('pedidos')">Cancelar</a>
    </div>    

    <script>

        var jsonObj_{{$key}} = [];
              
      
        $('#items_{{$key}}').combogrid({
            onSelect: function(param){
               $('#btnAdd_{{$key}}').linkbutton('enable');               
            }
        });

        function agregar_material_{{$key}}(){
          
            if($("#cantidad_{{$key}}").val()=="") return;

            var g = $('#items_{{$key}}').combogrid('grid'); // get datagrid object
            var r = g.datagrid('getSelected');  // get the selected row

            for(var i=0;i<jsonObj_{{$key}}.length;i++){
                    if(jsonObj_{{$key}}[i].id == r.id){
                        //si ya se agrego un material no se deja agregar mas
                        return; 
                    }
                }            

            item = {}
            item ["id"] = r.id;
            item ["codigo"] = r.codigo;
            item ["nombre"] = r.nombre;
            item ["unidad_medida"] = r.unidad_medida;
            item ["cantidad"] = $("#cantidad_{{$key}}").val();
            item ["nota"] = $("#nota_{{$key}}").val();
            item ["costo_unitario"] = r.costo_unitario;
            item ["costo_total"] = redondeo((r.costo_unitario*$("#cantidad_{{$key}}").val()),2);

            
            jsonObj_{{$key}}.push(item);

            var aux = JSON.stringify(jsonObj_{{$key}});
          
            var obj = jQuery.parseJSON( '{"rows":'+aux+'}' );

            $('#dgProductos_{{$key}}').datagrid({data: obj});

            $('#items_{{$key}}').combogrid('setValue',' ');
            $("#cantidad_{{$key}}").numberbox('clear');
            $('#btnAdd_{{$key}}').linkbutton('disable');
            $("#nota_{{$key}}").val("");


            
        }

        function eliminar_material_{{$key}}(){

            var row=$('#dgProductos_{{$key}}').datagrid('getSelected');
            var restar;

            if(row){    

                for(var i=0;i<jsonObj_{{$key}}.length;i++){
                    if(jsonObj_{{$key}}[i].id == row.id){
                        jsonObj_{{$key}}.splice(i, 1);
                        break;
                    }
                }
            
                
            var aux = JSON.stringify(jsonObj_{{$key}});          
            var obj = jQuery.parseJSON( '{"rows":'+aux+'}' );
                        
            
            $('#dgProductos_{{$key}}').datagrid({data: obj});

            }
              
        }

        function guardar_producto_{{$key}}(){

           
            var cliente=$('#cliente_{{$key}}').combobox('getValue');
            var fecha_pedido=$("#fecha_pedido_{{$key}}").datebox('getValue');            
                      
            if(cliente==""){
                mensajeAlerta("Debe Seleccionar el Cliente");
                return;
            }

            if(fecha_pedido==""){
                mensajeAlerta("Debe ingresar la Fecha del Pedido");
                return;
            }            

            if(jsonObj_{{$key}}.length==0){
                 mensajeAlerta("Debe Agregar al menos un Item");
                 return;
            }

            var itemsJSON = JSON.stringify(jsonObj_{{$key}});
                
            
            // Realizamos la petición al servidor
            
            $.post('pedidos/CRUD?param=c', {cliente: cliente, fecha_pedido: fecha_pedido, items: itemsJSON},
                function(respuesta) {
                     mensajeInfo(respuesta);
                     reloadTab('pedidos');
            }).error(
                function(){
                     mensajeError('Error al Crear Pedido');
                }
            );
 
        }


        $(".solo-mayusculas").on("keyup", function(event) {
            mayus($(this),event);
        });


        </script>  