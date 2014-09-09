 <div class="easyui-panel" title="Nuevo Producto" style="width:auto">
        <div style="padding:10px 10px 10px 10px">
        <form id="ff" method="post">
            <table cellpadding="5">
                <tr>

                    <td>Tipo de Producto:</td>
                    <td>
                       <select id="tipo_producto_{{$key}}" class="easyui-combogrid" style="width:80px" data-options="
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
                    </select>
                    </td>

                    <td>Sub Tipo de Producto:</td>
                    <td>
                        <select id="sub_tipo_producto_{{$key}}" class="easyui-combogrid" style="width:80px" data-options="
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
                    </select>
                    </td>

                    <!--- SCRIPT DE LOS COMBOS PARA ARMAR EL CODIGO -->
                    <script>
                        $('#tipo_producto_{{$key}}').combogrid({
                            onSelect: function(){
                              
                              var r = $(this).datagrid('getSelected');
                              $('#sub_tipo_producto_{{$key}}').combogrid({url:'catalogos/sub_tipo_productoCRUD?param=r&id='+r.id});

                              $("#codigo_{{$key}}").val("");
                              
                            }
                        });

                        $('#sub_tipo_producto_{{$key}}').combogrid({
                            onSelect: function(){
                              
                              var tp = $('#tipo_producto_{{$key}}').combogrid('grid');   // get datagrid object
                              var rtp = tp.datagrid('getSelected');  // get the selected row
                              var r = $(this).datagrid('getSelected');

                              $.get( "productos/num_codigo?id="+r.id, function( data ) {
                                  $("#codigo_{{$key}}").val(rtp.codigo+"-"+r.codigo+"-"+data);
                                });

                              $('#comboprocesos_{{$key}}').combogrid({url:'procesos/combobox?sub_tipo_producto_id='+r.id});

                              $('#centro_costo_{{$key}}').combobox('reload','procesos/ccostos_proceso?id=0');
                              $('#centro_costo_{{$key}}').combobox('setValue','');


                               costo_total_{{$key}}-=costo_mo_{{$key}}+costo_gf_{{$key}};
                               $("#costo_total_{{$key}}").val(redondeo(costo_total_{{$key}},2));
                               ActualizarCostoUnidad_{{$key}}();

                                costo_mo_{{$key}} = 0;
                                costo_gf_{{$key}} = 0;                    

                            }
                        });
                    </script>
                    <!--- -->

                    <td>Codigo:</td>
                    <td><input class="easyui-validatebox textbox in-disabled" disabled="true" type="text" id="codigo_{{$key}}" name="codigo" data-options="required:true"></input></td>
                                                         
                </tr>
                
                <tr>

                    <td>Nombre:</td>
                    <td colspan="3"><input class="easyui-validatebox solo-mayusculas" type="text" name="nombre_prod" id="nombre_prod_{{$key}}" data-options="required:true" style="width:445px"/></td>


                    <td>Unidad de Medida:</td>
                    <td>
                        <input class="easyui-combobox" name="unidad_medida" id="unidad_medida_{{$key}}" data-options="url:'catalogos/unidad_medidaCRUD?param=r',
                                                method:'get',
                                                valueField:'id',
                                                textField:'nombre',
                                                panelHeight:'auto',
                         "> 
                    </td>
                </tr>

                <tr>
                    <td>Stock Min:</td>
                    <td><input id="stock_min_{{$key}}" class="easyui-numberbox in-numerico" data-options="min:0,precision:3"></td>
                    <td>Stock Max:</td>
                    <td><input id="stock_max_{{$key}}" class="easyui-numberbox in-numerico" data-options="min:0,precision:3"></td>
                    <td>Crear Ficha de Producto:</td>
                    <td><input type="checkbox"  id="check_ficha_{{$key}}"></td>                    
                </tr>

                <tr>
                    <td class="td_costo">Costo del Producto:</td>
                    <td class="td_costo"><input id="costo_{{$key}}" class="easyui-numberbox in-numerico" data-options="min:0,precision:2"></td>
                </tr>   
                
                <script>
                    $("#check_ficha_{{$key}}").click(function() {
                            
                            if($(this).is(':checked')){
                                $('#ficha_{{$key}}').panel('expand',true);
                                $('.td_costo').css('display','none');
                                }
                            else{
                                $('#ficha_{{$key}}').panel('collapse',true);
                                $('.td_costo').css('display','');
                                }
                                
                        });                      
                </script>
               
                
            </table>
        </form>        
        </div>
    </div>
    <br>
    <div class="easyui-panel" id="ficha_{{$key}}" title="Ficha de Producto" collapsed="true" style="width:auto">
        <div style="padding:10px 10px 10px 10px">
            <table>
                <tr>
                    <td>Proceso:</td>
                    <td>
                        <select id="comboprocesos_{{$key}}" class="easyui-combogrid" style="width:150px" data-options="
                            panelWidth: 500,
                            idField: 'id',
                            textField: 'nombre',
                            method: 'get',
                            columns: [[
                                {field:'codigo',title:'Codigo',width:80},
                                {field:'nombre',title:'nombre',width:120},                                
                            ]],
                            fitColumns: true
                            ">
                        </select>

                    </td>
                    <td>Lote:</td>
                    <td><input  class="easyui-numberbox" type="text" value="1" name="lote" id="lote_{{$key}}" data-options="required:true"/></td>
                </tr>
                <tr>
                    <td>Costo Total:</td>
                    <td><input  class="easyui-numberbox in-numerico in-disabled" disabled="true" type="text" id="costo_total_{{$key}}" name="costo_total"/></td>
                    <td>Costo por Unidad:</td>
                    <td><input  class="easyui-numberbox in-numerico in-disabled" disabled="true" type="text" id="costo_unidad_{{$key}}" name="costo_unidad"/></td>
                </tr>    
            </table>

        </div>
    
    <div class="easyui-tabs" style="width:auto;height:350px">

        <div title="Materiales" style="padding:5px">

            <br>    
            <table>
                <td>Productos:</td>
                <td>
                    <select id="cg_{{$key}}" class="easyui-combogrid" style="width:250px" data-options="
                            panelWidth: 500,
                            idField: 'id',
                            textField: 'nombre',
                            url: 'productos/listar_productos?mat=s',
                            method: 'get',
                            columns: [[
                                {field:'codigo',title:'Codigo',width:80},
                                {field:'nombre',title:'Descripcion',width:120},
                                {field:'unidad_medida',title:'Unidad',width:80},
                                {field:'costo_unitario',title:'Costo Unitario',width:80}                                
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
                    C. Costos de Consumo:
                </td> 
                <td>
                 <input class="easyui-combobox" id="centro_costo_{{$key}}" 
                        data-options="method:'get',valueField:'id',textField:'nombre', panelHeight:'auto'"> 
                </td>
                <td>
                    <a href="javascript:void(0)" id="btnAdd" disabled="true" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="agregar_material_{{$key}}();"></a>
                </td>
                <td>
                    <a href="javascript:void(0)" id="btnDel" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar_material_{{$key}}();"></a>
                </td>    
            </table>
            <br>

            <table class="easyui-datagrid" id="dgMateriales_{{$key}}" style="width:auto;height:240px"
                fitColumns="true" rownumbers="true"
                singleSelect="true" pagination="false" showFooter="true">
            <thead>
                <tr>
                    <th data-options="field:'codigo',width:50">Codigo</th>
                    <th data-options="field:'nombre',width:120,">Descripción</th>
                    <th data-options="field:'ccosto_consumo',width:50,">C. Costo de Consumo</th>
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

    <div style="text-align:right;padding:5px; width:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardar_producto_{{$key}}()">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"onclick="reloadTab('productos')">Cancelar</a>
    </div>    

    <script>

        var jsonObj_{{$key}} = [];
        var costo_materiales_{{$key}} = 0;
        var costo_mo_{{$key}} = 0;
        var costo_gf_{{$key}} = 0;       
        var costo_total_{{$key}} = 0;
        var lote_{{$key}} = 1;

        
        function ActualizarCostoUnidad_{{$key}}(){

             if(lote_{{$key}}<=0)
                lote_{{$key}}=1;

             $("#costo_unidad_{{$key}}").val(redondeo(costo_total_{{$key}}/lote_{{$key}},2));      
             
        }

        $('#comboprocesos_{{$key}}').combogrid({
            onSelect: function(){
               
               var r = $(this).datagrid('getSelected');

               $('#tgManoObra_{{$key}}').treegrid({url:'procesos/tree_ccostos_mo?id='+r.id});
               $('#tgManoObra_{{$key}}').treegrid('reload'); 

               $('#tgFabricacion_{{$key}}').treegrid({url:'procesos/tree_ccostos_gf?id='+r.id});
               $('#tgFabricacion_{{$key}}').treegrid('reload');

               $('#centro_costo_{{$key}}').combobox('reload','procesos/ccostos_proceso?id='+r.id);


               $.getJSON('procesos/costo_proceso?id='+r.id,{format: "json"},function( data ) {
                    
                    costo_total_{{$key}}-=costo_mo_{{$key}}+costo_gf_{{$key}};

                    costo_mo_{{$key}} = data['costo_mo'];
                    costo_gf_{{$key}} = data['costo_gf'];
                    
                    costo_total_{{$key}}+=costo_mo_{{$key}}+costo_gf_{{$key}};

                    $("#costo_total_{{$key}}").val(redondeo(costo_total_{{$key}},2));
                    ActualizarCostoUnidad_{{$key}}();                    

                 });

            }
        });

        $( "#lote_{{$key}}" ).keyup(function() {
            
            if($(this).val()=="" || $(this).val()==".")
                lote_{{$key}}=1;
            else
                lote_{{$key}}=$(this).val();

            ActualizarCostoUnidad_{{$key}}();
        });

        $('#cg_{{$key}}').combogrid({
            onSelect: function(param){
               $('#btnAdd').linkbutton('enable');               
            }
        });

        function agregar_material_{{$key}}(){
          
            if($("#cantidad_{{$key}}").val()=="") return;

            if($('#centro_costo_{{$key}}').combobox('getValue')=="") return;

            var g = $('#cg_{{$key}}').combogrid('grid'); // get datagrid object
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
            item ["ccosto_id"] = $('#centro_costo_{{$key}}').combobox('getValue');
            item ["ccosto_consumo"] = $('#centro_costo_{{$key}}').combobox('getText');
            item ["unidad_medida"] = r.unidad_medida;
            item ["cantidad"] = $("#cantidad_{{$key}}").val();
            item ["costo_unitario"] = r.costo_unitario;
            item ["costo_total"] = redondeo((r.costo_unitario*$("#cantidad_{{$key}}").val()),2);

            costo_materiales_{{$key}} = costo_materiales_{{$key}} + item ["costo_total"];
            costo_materiales_{{$key}} = redondeo(costo_materiales_{{$key}},2);

            jsonObj_{{$key}}.push(item);

            var aux = JSON.stringify(jsonObj_{{$key}});
          
            var obj = jQuery.parseJSON( '{"rows":'+aux+',"footer":[{"codigo":"Costo Total Materiales:","costo_total":"'+costo_materiales_{{$key}}+'"}]}' );

            $('#dgMateriales_{{$key}}').datagrid({data: obj});

            $('#cg_{{$key}}').combogrid('setValue',' ');
            $("#cantidad_{{$key}}").numberbox('clear');
            $('#centro_costo_{{$key}}').combobox('setValue','');


            costo_total_{{$key}}+=item ["costo_total"];
            costo_total_{{$key}}=redondeo(costo_total_{{$key}},2)
            $("#costo_total_{{$key}}").val(costo_total_{{$key}});
            ActualizarCostoUnidad_{{$key}}();
        }

        function eliminar_material_{{$key}}(){

            var row=$('#dgMateriales_{{$key}}').datagrid('getSelected');
            var restar;

            if(row){    

                for(var i=0;i<jsonObj_{{$key}}.length;i++){
                    if(jsonObj_{{$key}}[i].id == row.id){
                        costo_materiales_{{$key}}-=row.costo_total;
                        restar = row.costo_total;
                        jsonObj_{{$key}}.splice(i, 1);
                        break;
                    }
                }
            
                
            var aux = JSON.stringify(jsonObj_{{$key}});          
            var obj = jQuery.parseJSON( '{"rows":'+aux+',"footer":[{"codigo":"Costo Total Materiales:","costo_total":"'+redondeo(costo_materiales_{{$key}},2)+'"}]}' );
                        

            costo_total_{{$key}}-=restar;
            costo_total_{{$key}}=redondeo(costo_total_{{$key}},2)
            $("#costo_total_{{$key}}").val(costo_total_{{$key}});
            ActualizarCostoUnidad_{{$key}}();

            $('#dgMateriales_{{$key}}').datagrid({data: obj});

            }
              
        }

        function guardar_producto_{{$key}}(){

            

            var codigo=$("#codigo_{{$key}}").val();
            var nombre=$("#nombre_prod_{{$key}}").val();
            var unidad_medida=$('#unidad_medida_{{$key}}').combobox('getValue');
          

            var stock_min = $("#stock_min_{{$key}}").val();

            if(stock_min<0 || stock_min=="")
                stock_min=null;

            var stock_max = $("#stock_max_{{$key}}").val();

            if(stock_max<0 || stock_max=="")
                stock_max=null;

            var check_ficha = $("#check_ficha_{{$key}}").is(':checked');

            if(codigo==""){
                mensajeAlerta("Debe Definer el Codigo del Producto");
                return;
            }

            var r = $('#sub_tipo_producto_{{$key}}').combogrid('grid').datagrid('getSelected');  // get the selected row
            var sub_tipo_prod = r.id;

            if(nombre==""){
                mensajeAlerta("Debe Ingresar el Nombre del Producto");
                return;
            }

            if(unidad_medida==""){
                mensajeAlerta("Debe Seleccionar la Unidad de Medida");
                return;
            }

            var costo_unitario = $("#costo_{{$key}}").val();

            if(check_ficha){

                var proceso=$('#comboprocesos_{{$key}}').combobox('getValue');

                if(proceso==""){
                    mensajeAlerta("Debe Seleccionar el Proceso de Produccion");
                    return;
                }

                if(jsonObj_{{$key}}.length==0){
                    mensajeAlerta("Debe Agregar los Materiales");
                    return;
                }

                var materialesJSON = JSON.stringify(jsonObj_{{$key}});
                
                var costo_unitario = $("#costo_unidad_{{$key}}").val();                                                

            }


           
           

            // Realizamos la petición al servidor
            
            $.post('productos/guardar_producto', {stock_min: stock_min, stock_max: stock_max,check_ficha: check_ficha,
                sub_tipo_prod: sub_tipo_prod, materiales: materialesJSON,costo_unitario: costo_unitario,
                codigo: codigo, nombre: nombre, unidad_medida: unidad_medida, proceso: proceso, lote: lote_{{$key}}},
                function(respuesta) {
                     mensajeInfo(respuesta);
                     reloadTab('productos');
            }).error(
                function(){
                     mensajeError('Error al Crear Producto');
                }
            );
 
        }


        $(".solo-mayusculas").on("keyup", function(event) {
            mayus($(this),event);
        });


        </script>  