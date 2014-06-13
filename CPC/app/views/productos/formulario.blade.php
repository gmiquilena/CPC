 <div class="easyui-panel" title="Nuevo Producto" style="width:700px">
        <div style="padding:10px 60px 20px 60px">
        <form id="ff" method="post">
            <table cellpadding="5">
                <tr>
                    <td>Nombre:</td>
                    <td><input class="easyui-validatebox textbox" type="text" name="name" data-options="required:true"></input></td>
                </tr>
                <tr>
                    <td>Unidad de Medida:</td>
                    <td><input class="easyui-validatebox textbox" type="text" name="email" data-options="required:true,validType:'email'"></input></td>
                </tr>
                <tr>
                    <td>Familia:</td>
                    <td><select class="easyui-combobox" name="language">
                            <option>--Seleccione--</option>
                            <option>Crema pastelera</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Sub-Familia:</td>
                    <td><select class="easyui-combobox" name="language">
                            <option>--Seleccione--</option>
                            <option>Crema pastelera</option>
                        </select>
                    </td>
                </tr>
                
            </table>
        </form>
        <div style="text-align:center;padding:5px">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">Limpiar</a>
        </div>
        </div>
    </div>
    <style scoped="scoped">
        .textbox{
            height:20px;
            margin:0;
            padding:0 2px;
            box-sizing:content-box;
        }
    </style>
    <script>
        function submitForm(){
            $('#ff').form('submit');
        }
        function clearForm(){
            $('#ff').form('clear');
        }
    </script>