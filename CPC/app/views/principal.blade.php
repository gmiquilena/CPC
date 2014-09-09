<script type="text/javascript">
			
			function openTab(plugin){
				if ($('#tt').tabs('exists',plugin)){
					$('#tt').tabs('select', plugin);
				} else {
					$('#tt').tabs('add',{
						title:plugin,
						href:plugin,
						closable:true,
						extractor:function(data){
							data = $.fn.panel.defaults.extractor(data);
							var tmp = $('<div style="padding:6px"></div>').html(data);
							//data = tmp.find('#content').html();
							//tmp.remove();
							return tmp;
						}
					});
				}
			}

			function reloadTab(pag){
				var tab = $('#tt').tabs('getSelected');  // get selected panel
				$('#tt').tabs('update', {
					tab: tab,
					options: {
						title: pag,
						href: pag  // the new content URL
					}
				});
			}

		</script>
		<style type="text/css">
			.e-link{
				text-decoration: none;
				color:#000000;
			}
			.e-link:hover{
				text-decoration: underline;
				color:#000000;
			}
		</style>
	</head>
	<body class="easyui-layout" style="text-align:left">
		<div region="north" border="false" style="text-align:center;height:40px">


				<div class="easyui-panel" style="padding:5px; width:500px">
			        <a href="#" class="easyui-menubutton" data-options="menu:'#mm1',iconCls:'icon-ordenes'">Gestión</a>
			        <a href="#" class="easyui-menubutton" data-options="menu:'#mm2',iconCls:'icon-config'">Administracion</a>			        
			    </div>

				    <div id="mm1" style="width:180px;">
				    	
				        <div><a class="e-link" href="#" onclick="openTab('pedidos')">Pedidos</a></div>	
				    	<div><a class="e-link" href="#" onclick="openTab('catalogos/inventario')">Inventario</a></div>
				    	<div><a class="e-link" href="#" onclick="openTab('orden_produccion')">Orden de Producción</a></div>
				    	<div><a class="e-link" href="#" onclick="openTab('orden_produccion/produccion')">Producción</a></div>				        
				    </div>

			
				    <div id="mm2" style="width:180px;">
				    	<div>
				            <span>Maestros</span>
				            <div>
				                <div><a class="e-link" href="#" onclick="openTab('catalogos/tipo_producto')">Tipos de Productos</a></div>
				                <div><a class="e-link" href="#" onclick="openTab('catalogos/unidad_medida')">Unidad de Medida</a></div>
				                <div><a class="e-link" href="#" onclick="openTab('catalogos/cliente')">Clientes</a></div>				                                
				            </div>
				        </div>
				        <div><a class="e-link" href="#" onclick="openTab('productos')">Productos</a></div>	
				    	<div><a class="e-link" href="#" onclick="openTab('ccostos')">Centros de Costos</a></div>
		            	<div><a class="e-link" href="#" onclick="openTab('procesos')">Procesos de Fabricación</a></div>				        
				    </div>
				
				

			<!--
				<table cellpadding="0" cellspacing="0" style="width:100%;">
					<tr>
						<td style="height:52px;">
							<div style="color:#fff;font-size:22px;font-weight:bold;">
								<a href="/index.php" style="color:#fff;font-size:22px;font-weight:bold;text-decoration:none">Sistema de Control de Producción</a>
							</div>
							<div style="color:#fff">
								<a href="/index.php" style="color:#fff;text-decoration:none">Aqui puede ir una descripción</a>
							</div>
						</td>					
					</tr>
				</table>
			-->
			
		<!--</div>
		<div region="west" split="true" title="Alertas" style="width:250px;padding:5px;">-->
				
		</div>
		<div region="center">
			<div id="tt" class="easyui-tabs" fit="true" border="false" plain="true">
				<div href="escritorio" data-options="iconCls:'icon-home'" title="Inicio"></div>
			</div>
		</div>
