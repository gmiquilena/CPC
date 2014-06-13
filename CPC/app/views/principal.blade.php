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
			        <a href="#" class="easyui-menubutton" data-options="menu:'#mm2',iconCls:'icon-proceso'">Administracion</a>
			        <a href="#" class="easyui-menubutton" data-options="menu:'#mm3'">About</a>
			    </div>

				    <div id="mm2" style="width:180px;">
				    	<div>
				            <span>Productos</span>
				            <div>
				                <div><a class="e-link" href="#" onclick="openTab('productos/agregar')">Crear Producto</a></div>	                
				            </div>
				        </div>
				    	<div><a class="e-link" href="#" onclick="openTab('ccostos')">Centros de Costos</a></div>
		            	<div><a class="e-link" href="#" onclick="openTab('procesos')">Procesos de Fabricación</a></div>				        
				    </div>
				    <div id="mm3" class="menu-content" style="background:#f0f0f0;padding:10px;text-align:left">
				        <img src="http://www.jeasyui.com/images/logo1.png" style="width:150px;height:50px">
				        <p style="font-size:14px;color:#444;">Try jQuery EasyUI to build your modern, interactive, javascript applications.</p>
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
			
		</div>
		<div region="west" split="true" title="Alertas" style="width:250px;padding:5px;">
				
		</div>
		<div region="center">
			<div id="tt" class="easyui-tabs" fit="true" border="false" plain="true">
				<div title="Escritorio" href=""></div>
			</div>
		</div>
